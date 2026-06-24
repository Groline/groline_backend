<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Services\ChargilyService;
use Illuminate\Support\Facades\Validator;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AuthController extends Controller
{
  //
  public function register(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'uid' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }


    $auth = Firebase::auth();

    try {
      //$firebase_user = $auth->getUser($request->uid);

      //$firebase_token = $auth->verifyIdToken($request->firebase_token);

      //$uid = $firebase_token->claims()->get('sub');

      $firebase_user = $auth->getUser($request->uid);

      $user = User::create([
        'name' => $firebase_user->displayName,
        'email' => $firebase_user->email,
        'phone' => $firebase_user->phoneNumber,
        'image' => $firebase_user->photoUrl,
      ]);

      $token = $user->createToken($this->random())->plainTextToken;

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'token' => $token,
        'data' => new UserResource($user),
      ]);
    } catch (Exception $e) {
      //dd($e->getMessage());

      return response()->json([
        'status' => 0,
        'message' => $e->getMessage(),
      ]);
    }
  }

  public function login(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'uid' => 'required',
      'fcm_token' => 'sometimes',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    $auth = Firebase::auth();

    try {

      $firebase_user = $auth->getUser($request->uid);

      $user = User::firstOrCreate(
        ['email' => $firebase_user->email],
        [
          'name' => $firebase_user->displayName ?? 'GRO-' . $this->random(6),
          'phone' => $firebase_user->phoneNumber,
          'image' => $firebase_user->photoUrl,
        ]
      )->refresh();

      switch ($user->status) {
        case 0:
          throw new Exception('blocked account');
        case 2:
          throw new Exception('deactivated account');
      }

      if (empty($user->customer_id) && $user->phone) {
        $chargily = new ChargilyService();
        $customer_id = $chargily->createCustomer($user->name, $user->email, $user->phone);

        if ($customer_id) {
          $user->customer_id = $customer_id;
          $user->save();
        }
      }

      if ($request->has('fcm_token')) {
        $user->fcm_token = $request->fcm_token;
        $user->save();
      }

      $token = $user->createToken($this->random())->plainTextToken;

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'token' => $token,
        'data' => new UserResource($user),
      ]);
    } catch (Exception $e) {
      //dd($e->getMessage());

      return response()->json([
        'status' => 0,
        'message' => $e->getMessage(),
      ]);
    }
  }

  public function logout(Request $request)
  {
    try {
      $user = $request->user();
      $user->currentAccessToken()->delete();
      $user->update(['fcm_token' => null]);

      return response()->json([
        'status' => 1,
        'message' => 'logged out',
      ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 0,
        'message' => $e->getMessage(),
      ]);
    }
  }
}
