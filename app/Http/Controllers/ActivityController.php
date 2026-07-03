<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function index(){
      return view('content.activities.list');
    }

    public function create(Request $request){
      $validator = Validator::make($request->all(), [
        'name_ar' => 'required|string',
        'name_en' => 'sometimes|nullable|string',
        'name_fr' => 'sometimes|nullable|string',
      ]);

      if ($validator->fails()) {
        return response()->json([
          'status'=> 0,
          'message' => $validator->errors()->first()
        ]);
      }

      try{
        $activity = Activity::create($request->only('name_ar', 'name_en', 'name_fr'));

        return response()->json([
          'status' => 1,
          'message' => 'success',
          'data' => new ActivityResource($activity)
        ]);

      }catch(Exception $e){
        return response()->json([
          'status' => 0,
          'message' => $e->getMessage()
        ]);
      }
    }

    public function update(Request $request){

      $validator = Validator::make($request->all(), [
        'activity_id' => 'required',
        'name_ar' => 'sometimes|string',
        'name_en' => 'sometimes|nullable|string',
        'name_fr' => 'sometimes|nullable|string',
      ]);

      if ($validator->fails()){
        return response()->json([
            'status' => 0,
            'message' => $validator->errors()->first()
          ]
        );
      }

      try{

        $activity = Activity::findOrFail($request->activity_id);

        $activity->update($request->except('activity_id'));

        return response()->json([
          'status' => 1,
          'message' => 'success',
          'data' => new ActivityResource($activity)
        ]);

      }catch(Exception $e){
        return response()->json([
          'status' => 0,
          'message' => $e->getMessage()
        ]);
      }

    }

    public function delete(Request $request){

      $validator = Validator::make($request->all(), [
        'activity_id' => 'required',
      ]);

      if ($validator->fails()){
        return response()->json([
            'status' => 0,
            'message' => $validator->errors()->first()
          ]
        );
      }

      try{

        $activity = Activity::findOrFail($request->activity_id);

        $activity->delete();

        return response()->json([
          'status' => 1,
          'message' => 'success',
        ]);

      }catch(Exception $e){
        return response()->json([
          'status' => 0,
          'message' => $e->getMessage()
        ]);
      }

    }

    public function restore(Request $request){

      $validator = Validator::make($request->all(), [
        'activity_id' => 'required',
      ]);

      if ($validator->fails()){
        return response()->json([
            'status' => 0,
            'message' => $validator->errors()->first()
          ]
        );
      }

      try{

        $activity = Activity::withTrashed()->findOrFail($request->activity_id);

        $activity->restore();

        return response()->json([
          'status' => 1,
          'message' => 'success',
          'data' => new ActivityResource($activity)
        ]);

      }catch(Exception $e){
        return response()->json([
          'status' => 0,
          'message' => $e->getMessage()
        ]);
      }

    }

    public function get(Request $request){
      $validator = Validator::make($request->all(), [
        'search' => 'sometimes|string',
      ]);

      if ($validator->fails()){
        return response()->json([
            'status' => 0,
            'message' => $validator->errors()->first()
          ]
        );
      }

      try{
        $activities = Activity::orderBy('created_at','DESC');

        if($request->has('search')){
          $activities = $activities->where('name', 'like', '%' . $request->search . '%');
        }

        $activities = $activities->paginate(20);

        return response()->json([
          'status' => 1,
          'message' => 'success',
          'data' => $activities
        ]);

      }catch(Exception $e){
        return response()->json([
          'status' => 0,
          'message' => $e->getMessage()
        ]);
      }

    }
}
