<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Todo extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title', 'description', 'status'
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
        Cache::forget('todos.all');
        Cache::forget('todoTask.all');
    }

    public static function getAllTodos()
    {
        return Cache::rememberForever('todos.all', function () {
            return self::where('user_id', Auth::id())
                ->with('todoTasks')
                ->orderBy('todo_date', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->get();
        });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function todoTasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TodoTask::class);
    }
}
