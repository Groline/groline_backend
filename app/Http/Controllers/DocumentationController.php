<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\CloudMessage;

class DocumentationController extends Controller
{

  public function index(Request $request)
  {
    $documentations = Documentation::query()->get()->keyBy('name');

    return view('content.documentation.index', compact('documentations'));
  }

      public function update(Request $request)
  {
    $request->validate([
      'documentations' => 'required|array',
      'documentations.*.key' => 'required|in:privacy_policy,about,delete_account',
      'documentations.*.content_en' => 'nullable|string',
      'documentations.*.content_fr' => 'nullable|string',
      'documentations.*.content_ar' => 'nullable|string',
    ]);

    try {
      $items = $request->input('documentations', []);
      $keys = collect($items)->pluck('key')->filter()->values()->all();
      $models = Documentation::query()->whereIn('name', $keys)->get()->keyBy('name');

      foreach ($items as $documentation) {
        $key = $documentation['key'];

        $model = $models->get($key) ?? new Documentation(['name' => $key]);
        $model->content_en = $documentation['content_en'] ?? null;
        $model->content_fr = $documentation['content_fr'] ?? null;
        $model->content_ar = $documentation['content_ar'] ?? null;
        $model->save();
      }

      return redirect()->route('documentation.index')->with('success', __('success'));
    } catch (\Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

    public function privacy()
    {
      $privacy_policy = Documentation::privacy_policy();

      $data = $privacy_policy->content(session('locale'));

      $title = __($privacy_policy->name);

      return view('content.pages.privacy-policy',compact('data','title'));
    }

    public function delete_account()
    {
      $doc = \App\Models\Documentation::delete_account();

      $data = $doc->content(session('locale'));

      $title = __('Delete Your Account');

      return view('content.pages.delete-account', compact('data', 'title'));
    }
    public function privacy_policy(Request $request){
      try{

        $privacy_policy = Documentation::privacy_policy();

        return response()->json([
          'status' => 1,
          'message' => 'success',
          'data' => ['content' => $privacy_policy->content]
        ]);

      }catch(Exception $e){
        return response()->json([
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
      }
    }

    public function about(Request $request){
      try{

        $about = Documentation::about();

        return response()->json([
          'status' => 1,
          'message' => 'success',
          'data' => ['content' => $about->content]
        ]);

      }catch(Exception $e){
        return response()->json([
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
      }
    }
}
