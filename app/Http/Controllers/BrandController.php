<?php

namespace App\Http\Controllers;


use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Http\Resources\PaginatedBrandCollection;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        return view('content.brands.list');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'sometimes|nullable|string',
            'name_fr' => 'sometimes|nullable|string',
            'slug'    => 'required|string|unique:brands,slug',
            'status'  => 'sometimes|boolean',
            'image'   => 'sometimes|mimetypes:image/*'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {

            $brand = Brand::create($request->except('image'));

            if ($request->hasFile('image')) {
                $url = $request->image->store('/uploads/brands/images', 'upload');

                $brand->image = $url;
                $brand->save();
            }

            return response()->json([
                'status' => 1,
                'message' => 'success',
                'data' => new BrandResource($brand)
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|exists:brands,id',
            'name_ar'  => 'sometimes|string',
            'name_en'  => 'sometimes|nullable|string',
            'name_fr'  => 'sometimes|nullable|string',
            'slug'     => 'sometimes|string',
            'status'   => 'sometimes|boolean',
            'image'    => 'sometimes|mimetypes:image/*'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {

            $brand = Brand::findOrFail($request->brand_id);

            $data = $request->except('image', 'brand_id');

            if ($request->filled('slug')) {
                Validator::make(
                    ['slug' => $request->slug],
                    ['slug' => 'unique:brands,slug,' . $brand->id]
                )->validate();
            }

            $brand->update($data);

            if ($request->hasFile('image')) {
                $url = $request->image->store('/uploads/brands/images', 'upload');

                $brand->image = $url;
                $brand->save();
            }

            return response()->json([
                'status' => 1,
                'message' => 'success',
                'data' => new BrandResource($brand)
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {

            $brand = Brand::findOrFail($request->brand_id);

            if ($brand->products()->count() > 0) {
                throw new Exception('This brand has products attached to it');
            }

            $brand->delete();

            return response()->json([
                'status' => 1,
                'message' => 'success',
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function get(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {

            $brands = Brand::orderBy('created_at', 'DESC');

            if ($request->filled('search')) {
                $brands->where(function ($query) use ($request) {
                    $query->where('name_ar', 'like', '%' . $request->search . '%')
                        ->orWhere('name_en', 'like', '%' . $request->search . '%')
                        ->orWhere('name_fr', 'like', '%' . $request->search . '%')
                        ->orWhere('slug', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->has('all')) {

                $brands = $brands->get();

                return response()->json([
                    'status' => 1,
                    'message' => 'success',
                    'data' => new BrandCollection($brands)
                ]);
            }

            $brands = $brands->paginate(10);

            return response()->json([
                'status' => 1,
                'message' => 'success',
                'data' => new PaginatedBrandCollection($brands)
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

}
