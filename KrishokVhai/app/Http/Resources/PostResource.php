<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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

        $itemsUrl = [];
        if ($this->getMedia('posts') && count($this->getMedia('posts'))) {
            $mediaItems = $this->getMedia('posts');
            foreach ($mediaItems as $key => $item) {
                $itemsUrl[] .= $item->getFullUrl();
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'author_username' => $this->user->username,
            'author' => $this->author,
            'description' => html_entity_decode($this->description),
            'categories' => count($this->postCategory) > 0 ? PostCategoryResource::collection($this->postCategory) : null,
            'created_at' => $this->created_at,
            'first_image' => $this->getFirstMediaUrl('posts'),
            //'images_thumb' => MediaResource::collection($this->getMedia('posts')),
            'imageUrls' => count($itemsUrl) > 0 ? $itemsUrl : null,
        ];
    }
}
