<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginatedProductCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Session;

class ProductController extends Controller
{

  public function index()
  {
    $products = Product::all();
    $categories = Category::all();
    $units = Unit::all();
    $brands = Brand::all();
    return view('content.products.list')
      ->with('products', $products)
      ->with('categories', $categories)
      ->with('units', $units)
      ->with('brands', $brands);
  }
  public function create(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'subcategory_id' => 'required|exists:subcategories,id',
      'unit_id' => 'required|exists:units,id',
      'brand_id' => 'required|exists:brands,id',
      'name_ar' => 'required|string',
      'name_en' => 'sometimes|nullable|string',
      'name_fr' => 'sometimes|nullable|string',
      'image' => 'sometimes|mimetypes:image/*',
      'unit_price' => 'required|numeric',
      'pack_price' => 'required_with:pack_units|nullable|numeric',
      'pack_units' => 'required_with:pack_price|nullable|integer',
      'status' => 'required|in:1,2',
      'description' => 'sometimes|nullable|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 0,
        'message' => $validator->errors()->first()
      ]);
    }
    try {


      $product = Product::create($request->except('image'));

      if ($request->hasFile('image')) {
        $url = $request->image->store('/uploads/products/images', 'upload');

        /* $file = $request->image;
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $filename = 'products/' . $product->id . '/' . md5(time().$name) . '.' . $extension;

        $url = $this->firestore($file->get(),$filename); */

        $product->image = $url;
        $product->save();
      }


      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => new ProductResource($product)
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
    }
  }

  public function update(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'product_id' => 'required|exists:products,id',
      'unit_id' => 'sometimes|exists:units,id',
      'brand_id' => 'sometimes|exists:brands,id',
      'name_ar' => 'sometimes|string',
      'name_en' => 'sometimes|nullable|string',
      'name_fr' => 'sometimes|nullable|string',
      'image' => 'sometimes|mimetypes:image/*',
      'unit_price' => 'sometimes|numeric',
      'pack_price' => 'required_with:pack_units|nullable|numeric',
      'pack_units' => 'required_with:pack_price|nullable|integer',
      'status' => 'sometimes|in:1,2',
      'description' => 'sometimes|nullable|string',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $product = Product::findOrFail($request->product_id);

      $product->update($request->except('image', 'product_id'));

      if ($request->hasFile('image')) {
        $url = $request->image->store('/uploads/products/images', 'upload');

        /* $file = $request->image;
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $filename = 'products/' . $product->id . '/' . md5(time().$name) . '.' . $extension;

        $url = $this->firestore($file->get(),$filename); */

        $product->image = $url;
        $product->save();
      }

      if ($request->has('status')) {
        $product->notify($request->status == '1' ? 'available' : 'unavailable');
      }

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => new ProductResource($product)
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
    }

  }

  public function delete(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'product_id' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $product = Product::findOrFail($request->product_id);

      $product->delete();

      return response()->json([
        'status' => 1,
        'message' => 'success',
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
    }

  }

  public function restore(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'product_id' => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $product = Product::withTrashed()->findOrFail($request->product_id);

      $product->restore();

      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => new ProductResource($product)
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
    }

  }

  public function get(Request $request)
  {  //paginated
    $validator = Validator::make($request->all(), [
      'category_id' => 'sometimes|exists:categories,id',
      'subcategory_id' => 'sometimes|exists:subcategories,id',
      'brand_id' => 'sometimes|exists:brands,id',
      'search' => 'sometimes|string',

    ]);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 0,
          'message' => $validator->errors()->first()
        ]
      );
    }

    try {

      $products = Product::orderBy('created_at', 'DESC');
      //$products = $products->whereNotNull('image');

      if ($request->has('category_id')) {
        $products = $products->whereHas('subcategory', function ($query) use ($request) {
          $query->where('category_id', $request->category_id);
        });
      }

      if ($request->has('subcategory_id')) {
        $products = $products->where('subcategory_id', $request->subcategory_id);
      }

      if ($request->has('brand_id')) {
        $products = $products->where('brand_id', $request->brand_id);
      }

      if ($request->has('search')) {

        $products = $products->where(function ($query) use ($request) {
          $query->where('name_ar', 'like', '%' . $request->search . '%')
            ->orWhere('name_fr', 'like', '%' . $request->search . '%')
            ->orWhere('name_en', 'like', '%' . $request->search . '%');
        });
      }

      if ($request->has('all')) {
        $products = $products->get();
        return response()->json([
          'status' => 1,
          'message' => 'success',
          'data' => new ProductCollection($products)
        ]);

      }
      $products = $products->paginate(10);


      return response()->json([
        'status' => 1,
        'message' => 'success',
        'data' => new PaginatedProductCollection($products)
      ]);

    } catch (Exception $e) {
      return response()->json(
        [
          'status' => 0,
          'message' => $e->getMessage()
        ]
      );
    }

  }
}
