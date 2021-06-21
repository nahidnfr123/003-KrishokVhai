<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'social_id',
        'social_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isOnline()
    {
        return Cache::has('userOnline-' . $this->id);
    }

    /**
     * Get all users
     *
     * @return mixed
     */
    public static function getAllUsers()
    {
        return Cache::rememberForever('users.all', function () {
            return self::with('role')->latest()->get();
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache(): void
    {
        Cache::forget('users.all');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::updated(function () {
            self::flushCache();
        });
        static::created(function () {
            self::flushCache();
        });
        static::deleted(function () {
            self::flushCache();
        });
    }

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class);
    }


    public static function allExceptMe()
    {
        // Get all the user except the logged in user ....
        return self::where('id', '!=', \auth()->id())->latest('created_at')->get();
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function farmer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(FarmerDetails::class);
    }

    public function retailer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(RetailerDetails::class);
    }

    public function officer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OfficerDetails::class);
    }

    public function scopeSearchUsers($query, $s)
    {
        return $query->where('first_name', 'LIKE', '%' . $s . '%')
            ->orWhere('last_name', 'LIKE', '%' . $s . '%')
            ->orWhere('email', 'LIKE', '%' . $s . '%')
            ->orWhere('mobile_number', 'LIKE', '%' . $s . '%');
    }

    public function scopeWithFilters($query, $searchQuery, $searchRole, $searchStatus)
    {
        return $query->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('first_name', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('email', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('mobile_number', 'LIKE', '%' . $searchQuery . '%');

        })->when($searchRole, function ($query) use ($searchRole) {
            $query->role($searchRole);
        });

        /*return $query->when(count(request()->input('categories', [])), function ($query) {
            $query->whereIn('category_id', request()->input('categories'));
        });*/

    }


    public function post(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function todo(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Todo::class);
    }
}
