<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProductResource;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $post = Post::latest()->paginate(16);
        return (PostResource::collection($post))->response();
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
            'title' => ['required', 'string', Rule::unique(Post::class)],
            'slug' => ['required', 'string', Rule::unique(Post::class)],
            'type' => ['required', 'string'],
            'author' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category' => "required|array|min:1", /// category for displaying error in vue js ...
            'category.*' => "required|string", /// category for displaying error in vue js ...
            'images' => "sometimes|nullable|array|between:0,4",
            'images.*' => "image|mimes:jpeg,jpg,png,gif|max:2048",
        ]);
        $post = new Post();
        $post->title = ucfirst($request->title);
        $post->slug = $request->slug;
        $post->type = $request->type;
        if ($request->status == 'false') {
            $post->status = false;
        } else {
            $post->status = true;
        }
        $post->user_id = auth()->id();
        $post->author = $request->author;
        $post->description = $request->description;
        $post->save();
        if ($request->category) {
            foreach ($request->category as $categoryId) {
                $post->postCategory()->attach($categoryId);
            }
        }
        if ($request->images) {
            foreach ($request->images as $file) {
                try {
                    $post->addMedia($file)->toMediaCollection('posts');
                } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
                    return response()->json(['error', $e], 500);
                }
            }
        }
        return (new PostResource($post))->response();
    }


    public function uploadImage(Request $request): \Illuminate\Http\JsonResponse
    {

    }

    /**
     * Display the specified resource.
     *
     * @param String $post_slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $post_slug): \Illuminate\Http\JsonResponse
    {
        $post = Post::where('slug', $post_slug)->first();
        return (new PostResource($post))->response();
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
        $post = Post::findOrFail($id);

        $this->validate($request, [
            'title' => ['required', 'string', Rule::unique(Post::class)->ignore($post)],
            'slug' => ['required', 'string', Rule::unique(Post::class)->ignore($post)],
            'type' => ['required', 'string'],
            'author' => ['required', 'string'],
            'description' => ['required', 'string'],
            //'category' => ['required'], /// category for displaying error in vue js ...
            //'category.*' => !$request->categoryIds ? ['required', 'string'] : '', /// category for displaying error in vue js ...
            //'images' => $request->images || count($request->images) > 0 ? ['required', 'image'] : '',
            //'images.*' => $request->images && count($request->images) > 0 ? 'mimes:jpeg,jpg,png|max:2048' : '',

            'category' => "required|array|min:1", /// category for displaying error in vue js ...
            'category.*' => "required|string", /// category for displaying error in vue js ...
            'images' => "sometimes|array|between:0,4",
            'images.*' => "image|mimes:jpeg,jpg,png|max:2048",
        ]);

        $mediaItems = $post->getMedia('posts');
        if ($mediaItems && $request->images && count($mediaItems) + count($request->images) > 4) {
            return response()->json(['error' => 'A post can contain maximum 4 images.'], 422);
        }
        $post->title = ucfirst($request->title);
        $post->slug = $request->slug;
        $post->type = $request->type;
        if ($request->status == 'false') {
            $post->status = false;
        } else {
            $post->status = true;
        }
        $post->author = $request->author;
        $post->description = $request->description;
        $post->save();

        $post->postCategory()->detach();
        if ($request->category) {
            foreach ($request->category as $categoryId) {
                $post->postCategory()->attach($categoryId);
            }
        }
        if ($request->images) {
            foreach ($request->images as $file) {
                try {
                    $post->addMedia($file)->toMediaCollection('posts');
                } catch (DiskDoesNotExist | FileDoesNotExist | FileIsTooBig $e) {
                    return response()->json(['error', $e], 500);
                }
            }
        }
        return (new PostResource($post))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $post = Post::where('id', $id)->first();
        if (!$post->forceDelete()) {
            return response()->json(['error' => "Failed to delete post!"], 500);
        }
        return (new PostResource($post))->response();
    }


    /*public function postByUser(Request $request){

        return (PostResource::collection($posts->latest()->paginate(20)))->response();
    }*/

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $posts = Post::query()->with(['postCategory', 'user']);

        $query = $request->get('query');
        $postType = $request->get('postType');
        $postCategory = $request->get('postCategory');
        $showingAllPost = $request->get('showingAllPost');
        $status = $request->get('postStatus');

        $query ? $posts->SearchPosts($query) : false;

        if ($showingAllPost == false || $showingAllPost == "false") {
            $posts->where('user_id', Auth::id());
        }
        if ($postType) {
            $posts->where('type', $postType);
        }
        if ($status) {
            if ($status == 'active') {
                $posts->where('status', 1);
            }
            if ($status == 'inactive') {
                $posts->where('status', 0);
            }
        }
        return (PostResource::collection($posts->latest()->paginate(16)))->response();
    }

    public function deleteImage(int $key, int $postId): \Illuminate\Http\JsonResponse
    {
        $post = Post::findOrFail($postId);
        $mediaItems = $post->getMedia('posts');
        $mediaItems[$key]->delete();
        return (new PostResource($post))->response();
    }

    public function getPostFrontend(): \Illuminate\Http\JsonResponse
    {
        $query = request()->input('query');
        $category = request()->input('categories', []);
        $postType = request()->input('articles_type');
        $paginateLimit = request()->input('limit') ? request()->input('limit') : 8;


        $posts = Post::query()
            ->with(['postCategory', 'user'])
            ->where('type', $postType)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->withFilters($query, $category);

        return (PostResource::collection($posts->latest()->paginate($paginateLimit)))->response();
    }
}
