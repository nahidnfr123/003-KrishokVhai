<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Bid;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        if (Auth::user()->hasAnyRole(['developer', 'super admin', 'admin'])) {
            $products = Product::with('seller')->latest()->paginate(20);
        } else {
            $products = Product::with('seller')->where('seller_id', Auth::id())->latest()->paginate(20);
        }
        return (ProductResource::collection($products))->response();
    }

    public function showAllProducts(): \Illuminate\Http\JsonResponse
    {
        /*$products = Product::with('seller')->where('status', 1)->latest()->paginate(30);
        return (ProductResource::collection($products))->response();*/
        $query = request()->input('query');
        $limit = request()->input('limit');
        $category = request()->input('category', []);
        $price = request()->input('price', []);
        $location = request()->input('location');


        $product_query = Product::query()
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->withFilters($query, $category, $price, $location);

        if ($limit) {
            $products = $product_query->latest()->take((int)$limit)->paginate((int)$limit);
        } else {
            $products = $product_query->latest()->paginate(30);
        }

        return (ProductResource::collection($products))->response();
    }

    public function deletedCount(): \Illuminate\Http\JsonResponse
    {
        if (Auth::user()->hasAnyRole(['developer', 'super admin', 'admin'])) {
            $proAllCount = Product::with('seller')->count();
            $proDeletedCount = Product::onlyTrashed()->with('seller')->count();
        } else {
            $proAllCount = Product::with('seller')->where('seller_id', Auth::id())->count();
            $proDeletedCount = Product::onlyTrashed()->with('seller')->where('seller_id', Auth::id())->count();
        }
        return response()->json([
            'all' => $proAllCount,
            'deleted' => $proDeletedCount,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'product_name' => ['required', 'string'],
            //'product_slug' => ['required', 'string'],
            'category' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'brand_id' => 'sometimes|nullable|numeric',
            'status' => ['required', 'string'],
            'total_stock' => "required|numeric|min:0|max:2000",
            'stock_type' => "required|string",
            'regular_price' => "required|numeric|digits_between:1,7|gte:retail_price",
            'retail_price' => "required|numeric|digits_between:1,7",
            'minimum_order_amount' => "required|numeric|digits_between:1,4|min:1",
            'images' => "required|array|between:0,4",
            'images.*' => "image|mimes:jpeg,jpg,png,gif|max:2048",
        ]);
        $product = new Product();
        $product->product_name = ucfirst($request->product_name);
        //$product->product_slug = $request->product_slug;
        $product->description = $request->description;
        $product->can_bid = $request->can_bid;
        $product->brand_id = $request->brand_id;
        $product->total_stock = $request->total_stock;
        $product->stock_type = $request->stock_type;
        $product->regular_price = $request->regular_price;
        $product->retail_price = $request->retail_price;
        $product->minimum_order_amount = $request->minimum_order_amount;
        $product->seller_id = Auth::id();
        $request->status == 'false' ? $product->status = false : $product->status = true;

        $product->save();
        $product->productCategory()->attach($request->category);
        if ($request->images) {
            foreach ($request->images as $file) {
                try {
                    $product->addMedia($file)->toMediaCollection('products');
                } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
                    return response()->json(['error', $e], 500);
                }
            }
        }
        return (new ProductResource($product))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('product_slug', $slug)->first();
        return (new ProductResource($product))->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'product_name' => ['required', 'string'],
            //'product_slug' => ['required', 'string'],
            'category' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'brand_id' => 'sometimes|nullable|numeric',
            'status' => ['required', 'string'],
            'total_stock' => "required|numeric|min:0|max:2000",
            'stock_type' => "required|string",
            'regular_price' => "required|numeric|digits_between:1,7|gte:retail_price",
            'retail_price' => "required|numeric|digits_between:1,7",
            'minimum_order_amount' => "required|numeric|digits_between:1,4|min:1",
            'images' => "sometimes|nullable|array|between:0,4",
            'images.*' => "image|mimes:jpeg,jpg,png,gif|max:2048",
        ]);
        $product = Product::findOrFail($id);
        $product->product_name = ucfirst($request->product_name);
        //$product->product_slug = $request->product_slug;
        $product->description = $request->description;
        $product->brand_id = $request->brand_id;
        $product->total_stock = $request->total_stock;
        $product->stock_type = $request->stock_type;
        $product->regular_price = $request->regular_price;
        $product->retail_price = $request->retail_price;
        $product->minimum_order_amount = $request->minimum_order_amount;
        $product->seller_id = Auth::id();

        if ($request->status == 'false') {
            $product->status = false;
        } else {
            $product->status = true;
        }
        $product->save();
        $product->productCategory()->detach();
        $product->productCategory()->attach($request->category);

        if ($request->images) {
            foreach ($request->images as $file) {
                try {
                    $product->addMedia($file)->toMediaCollection('products');
                } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
                    return response()->json(['error', $e], 500);
                }
            }
        }
        return (new ProductResource($product))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('id', $id)->withTrashed()->first();
        if (!empty($product)) {
            if ($product->deleted_at) {
                if (!$product->forceDelete()) {
                    return response()->json(['error' => "Failed to destroy product!"], 500);
                }
            } else {
                if (!$product->delete()) {
                    return response()->json(['error' => "Failed to delete product!"], 500);
                }
            }
        }
        return (new ProductResource($product))->response();
    }


    public function showDeleted(): \Illuminate\Http\JsonResponse
    {
        $products = Product::onlyTrashed()->latest()->paginate(20);
        return (ProductResource::collection($products))->response();
    }

    public function restore($id): \Illuminate\Http\JsonResponse
    {
        $products = Product::onlyTrashed()->findOrFail($id);
        if (!$products->restore()) {
            return response()->json(['error' => "Failed to restore product!"], 500);
        }
        return (new ProductResource($products))->response();
    }

    public function deleteImage(int $key, $productId): \Illuminate\Http\JsonResponse
    {
        $product = Product::findOrFail($productId);
        $mediaItems = $product->getMedia('products');
        $mediaItems[$key]->delete();
        return (new ProductResource($product))->response();
    }
}
