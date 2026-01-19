<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    protected $table = 'apps';

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'app_user', 'app_id', 'user_id')
            ->withTimestamps();
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'app_id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'app_id');
    }
}
