<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Role  extends \Spatie\Permission\Models\Role
{
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
