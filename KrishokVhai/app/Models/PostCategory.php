<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'user_id',
    ];
    protected $guarded = ['id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_post_category', 'post_category_id', 'post_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    /*public function subcategory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id')
            ->orderby('title', 'ASC')
            ->select(['id', 'title', 'slug', 'parent_id', 'user_id'])
            ->withCount(['posts']);
    }

    public function child(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id')
            ->with('subcategory')
            ->orderby('title', 'ASC')
            ->select(['id', 'title', 'slug', 'parent_id', 'user_id'])
            ->withCount(['posts']);
    }*/

    /* public static function getAllCategoriesWithSubCategory()
     {
         return self::whereNull('parent_id')->withCount('posts')->orderby('title', 'ASC')->get();
     }*/

}
