<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCategoryResource;
use App\Http\Resources\ProductCategoryResource;
use App\Models\PostCategory;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $productCategory = ProductCategory::whereNull('parent_id')->get();
        return (ProductCategoryResource::collection($productCategory))->response();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): \Illuminate\Http\Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'title' => ['required', 'string', Rule::unique(ProductCategory::class)],
            'slug' => ['required', 'string', Rule::unique(ProductCategory::class)],
        ]);

        $productCategory = new ProductCategory();
        $productCategory->title = ucfirst($request->title);
        $productCategory->slug = $request->slug;
        if ($request->parent_id != null && $request->parent_id != '') {
            $productCategory->parent_id = $request->parent_id;
        }
        $productCategory->user_id = auth()->id();
        if ($productCategory->save()) {
            return (new ProductCategoryResource($productCategory))->response();
        }
        return response()->json(['error', 'Post category cannot be added!'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): \Illuminate\Http\Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): \Illuminate\Http\Response
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
        $productCategory = ProductCategory::where('id', $id)->first();
        if (!$productCategory) {
            return response()->json(['error' => "Failed to update category!"], 500);
        }
        $this->validate($request, [
            'title' => ['required', 'string', Rule::unique(PostCategory::class)->ignore($productCategory)],
            'slug' => ['required', 'string', Rule::unique(PostCategory::class)->ignore($productCategory)],
        ]);
        $productCategory->title = ucfirst($request->title);
        $productCategory->slug = $request->slug;
        if ($productCategory->save()) {
            return (new ProductCategoryResource($productCategory))->response();
        }
        return response()->json(['error' => "Failed to update category!"], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $productCategory = ProductCategory::where('id', $id)->first();
        if (!$productCategory->forceDelete()) {
            return response()->json(['error' => "Failed to delete category!"], 500);
        }
        return (new ProductCategoryResource($productCategory))->response();

    }
}
