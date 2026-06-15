<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Band;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BandResource;
use App\Rules\SizeIn;

class BandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('content.bands.list')->with('brands', $brands);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'sometimes|nullable|string',
            'name_fr' => 'sometimes|nullable|string',
            'brands'  => ['required', 'array', new SizeIn([4, 6])],
            'brands.*' => 'distinct|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            DB::beginTransaction();

            $band = Band::create($request->except('brands'));

            $band->brands()->attach($request->brands);

            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'success',
                'data'    => $band
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'band_id'  => 'required|exists:bands,id',
            'name_ar'  => 'sometimes|string',
            'name_en'  => 'sometimes|nullable|string',
            'name_fr'  => 'sometimes|nullable|string',
            'brands'   => ['sometimes', 'array', new SizeIn([4, 6])],
            'brands.*' => 'distinct|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $band = Band::findOrFail($request->band_id);

            DB::beginTransaction();

            $band->update($request->except('band_id', 'brands'));

            if ($request->has('brands')) {
                $band->brands()->sync($request->brands);
            }

            DB::commit();

            return response()->json([
                'status'  => 1,
                'message' => 'success',
                'data'    => $band
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'band_id' => 'required|exists:bands,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $band = Band::findOrFail($request->band_id);
            $band->delete();

            return response()->json([
                'status'  => 1,
                'message' => 'success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 0,
                'message' => $e->getMessage()
            ]);
        }
    }
}
