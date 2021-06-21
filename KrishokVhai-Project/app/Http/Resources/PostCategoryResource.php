<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'children' => count($this->children) > 0 ? self::collection($this->children) : null,
            'children_count' => count($this->children),
            'post_count' => $this->posts ? $this->posts->count() : null,


            'news_count' => $this->posts ? $this->posts->where('type', '=', 'news')->count() : null,
            'blog_count' => $this->posts ? $this->posts->where('type', '=', 'blog')->count() : null,
            'practice_count' => $this->posts ? $this->posts->where('type', '=', 'farming-practice')->count() : null,
        ];
    }
}
