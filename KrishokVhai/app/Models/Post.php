<?php

namespace App\Models;

use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia
{
    use HasFactory, HasMediaTrait;

    protected $guarded = ['id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postCategory(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(PostCategory::class, 'post_post_category', 'post_id', 'post_category_id');
    }


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('square')
            ->width(412)
            ->height(412)
            ->sharpen(10);
    }

    public function scopeSearchPosts($query, $s)
    {
        return $query->where('title', 'LIKE', '%' . $s . '%')
            ->orWhere('slug', 'LIKE', '%' . $s . '%');
    }

    public function scopeSearchPostsWithCategory($query, $s)
    {
        return $query->where('title', 'LIKE', '%' . $s . '%')
            ->orWhere('slug', 'LIKE', '%' . $s . '%');
    }

    public function scopeWithFilters($query, $searchQuery, $category)
    {
        return $query->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('title', 'LIKE', '%' . $searchQuery . '%');
            $query->orWhere('slug', 'LIKE', '%' . $searchQuery . '%');
            $query->orWhereHas('postCategory', function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', '%' . $searchQuery . '%');
                $q->orWhere('slug', 'LIKE', '%' . $searchQuery . '%');
            });
        })->when($category, function ($query) use ($category) {
            $query->whereHas('postCategory', function ($q) use ($category) {
                $q->whereIn('id', $category);
            });
        });
        /*return $query->when(count(request()->input('categories', [])), function ($query) {
            $query->whereIn('category_id', request()->input('categories'));
        });*/
    }

}
