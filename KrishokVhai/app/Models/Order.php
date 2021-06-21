<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $number = Order::get()->max('id') + 1;
            $model->order_no = '#O-' . str_pad($number, 5, '0', STR_PAD_LEFT);
        });
    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['quantity', 'buying_price', 'individual_order_status', 'seen']);
    }

    public function scopeWithFilters($query, $searchQuery, $status, $removedOrders, $sellerId, $pinned)
    {
        return $query->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('order_no', $searchQuery);
            /*$query->orWhere('product_slug', 'LIKE', '%' . $searchQuery . '%');*/
            $query->orWhereHas('user', function ($q) use ($searchQuery) {
                $q->where('first_name', 'LIKE', '%' . $searchQuery . '%');
                $q->orWhere('last_name', 'LIKE', '%' . $searchQuery . '%');
                $q->orWhere('username', 'LIKE', '%' . $searchQuery . '%');
                $q->orWhere('email', 'LIKE', '%' . $searchQuery . '%');
            });
            $query->orWhereHas('products', function ($q) use ($searchQuery) {
                $q->where('product_name', 'LIKE', '%' . $searchQuery . '%');
                $q->orWhere('product_slug', 'LIKE', '%' . $searchQuery . '%');
            });
            $query->orWhereHas('products', function ($q) use ($searchQuery) {
                $q->whereHas('productCategory', function ($q) use ($searchQuery) {
                    $q->where('title', 'LIKE', '%' . $searchQuery . '%');
                    $q->where('slug', 'LIKE', '%' . $searchQuery . '%');
                });
            });
        })
            ->when($status, function ($query) use ($status) {
                $query->where('order_status', $status);
            })
            ->when($sellerId, function ($query) use ($sellerId) {
                $query->whereHas('products', function ($q) use ($sellerId) {
                    $q->where('seller_id', $sellerId);
                });
            });

        /*return $query->when(count(request()->input('categories', [])), function ($query) {
            $query->whereIn('category_id', request()->input('categories'));
        });*/

    }

    public function scopeWithNewOrderFilters($query, $sellerId, $seen)
    {
        return $query->when($sellerId, function ($query) use ($sellerId) {
            $query->whereHas('products', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
                $q->where('seen', 0);
            });
        });

        /*return $query->when(count(request()->input('categories', [])), function ($query) {
            $query->whereIn('category_id', request()->input('categories'));
        });*/

    }


}
