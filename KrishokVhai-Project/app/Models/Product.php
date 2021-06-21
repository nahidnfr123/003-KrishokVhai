<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, HasMediaTrait, SoftDeletes;


    protected $guarded = ['id'];


    protected static function boot()
    {
        parent::boot();

        static::created(function ($product) {
            $product->product_slug = $product->createSlug($product->product_name);
            $product->save();
        });
    }

    private function createSlug($product_name)
    {
        if (static::where('product_slug', $product_slug = Str::slug($product_name))->exists()) {
            $max = static::where('product_name', $product_name)->latest('id')->skip(1)->value('product_slug');

            if (is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$product_slug}-2";
        }
        return $product_slug;
    }

    public function seller(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id')
            ->select(['id', 'first_name', 'last_name', 'username', 'email', 'mobile_number', 'avatar']);
    }

    public function productCategory(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_product_category', 'product_id', 'product_category_id')
            ->withPivot('product_category_id');
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class);
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

    public function scopeSearchProducts($query, $s)
    {
        return $query->where('product_name', 'LIKE', '%' . $s . '%')
            ->orWhere('product_slug', 'LIKE', '%' . $s . '%');
    }

    public function scopeSearchProductsWithCategory($query, $s)
    {
        return $query->where('product_name', 'LIKE', '%' . $s . '%')
            ->orWhere('product_slug', 'LIKE', '%' . $s . '%');
    }

    public function proCat(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_product_category', 'product_id', 'product_category_id');
    }

    public function scopeWithFilters($query, $searchQuery, $category, $price, $location)
    {
        return $query->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('product_name', 'LIKE', '%' . $searchQuery . '%');
            $query->orWhere('product_slug', 'LIKE', '%' . $searchQuery . '%');
            $query->orWhereHas('productCategory', function ($q) use ($searchQuery) {
                $q->where('title', 'LIKE', '%' . $searchQuery . '%');
            });
        })->when($category, function ($query) use ($category) {
            $query->whereHas('productCategory', function ($q) use ($category) {
                $q->whereIn('id', $category);
            });
        });

        /*return $query->when(count(request()->input('categories', [])), function ($query) {
            $query->whereIn('category_id', request()->input('categories'));
        });*/

    }


    /*public function scopeWithFilters($query, $prices, $categories, $manufacturers)
    {
        return $query->when(count($manufacturers), function ($query) use ($manufacturers) {
            $query->whereIn('manufacturer_id', $manufacturers);
        })
            ->when(count($categories), function ($query) use ($categories) {
                $query->whereIn('category_id', $categories);
            })
            ->when(count($prices), function ($query) use ($prices){
                $query->where(function ($query) use ($prices) {
                    $query->when(in_array(0, $prices), function ($query) {
                        $query->orWhere('price', '<', '5000');
                    })
                        ->when(in_array(1, $prices), function ($query) {
                            $query->orWhereBetween('price', ['5000', '10000']);
                        })
                        ->when(in_array(2, $prices), function ($query) {
                            $query->orWhereBetween('price', ['10000', '50000']);
                        })
                        ->when(in_array(3, $prices), function ($query) {
                            $query->orWhere('price', '>', '50000');
                        });
                });
            });
    }*/


}
