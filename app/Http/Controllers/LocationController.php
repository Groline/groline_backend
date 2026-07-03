<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PaginatedLocationCollection;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'region_id' => 'nullable|exists:regions,id',
            'address' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        $request->merge(['user_id' => auth()->id()]);

        $location = Location::create($request->all());


        return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' => new LocationResource($location)
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id',
            'address' => 'sometimes|nullable|string',
            'longitude' => 'sometimes|nullable|string',
            'latitude' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        $location = Location::find($request->location_id);

        $location->update($request->except('location_id'));

        return response()->json([
            'status' => 1,
            'message' => 'success',
            'data' => new LocationResource($location)
        ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location_id' => 'required|exists:locations,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        $location = Location::find($request->location_id);

        $location->delete();

        return response()->json([
            'status' => 1,
            'message' => 'success'
        ]);
    }

    public function get(Request $request){
      $validator = Validator::make($request->all(), [
        'all' => 'sometimes|boolean',
      ]);

      if ($validator->fails()){
        return response()->json([
            'status' => 0,
            'message' => $validator->errors()->first()
          ]
        );
      }

      $locations = auth()->user()->locations()->orderBy('created_at', 'DESC');

      if($request->has('all')){
        $locations = $locations->get();
        return response()->json([
          'status' => 1,
          'message' => 'success',
          'data' => new LocationCollection($locations)
        ]);
      }

      $locations = $locations->paginate(10);

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => new PaginatedLocationCollection($locations)
      ]);
    }
}
