<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class TodoTask extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title', 'status'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
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
    /**
     * Flush the cache
     */
    public static function flushCache(): void
    {
        Cache::forget('todoTask.all');
        Cache::forget('todos.all');
    }
    public static function getAllTodoItems()
    {
        return Cache::rememberForever('todoTask.all', static function() {
            /*return self::where('user_id', Auth::id())
                ->with('todoItems')
                ->orderBy('created_at', 'DESC')
                ->get();*/
        });
    }
    public function todo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Todo::class);
    }
}
