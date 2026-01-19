<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Granularity extends Model
{
    protected $fillable = [
        'app_id',
        'resource',
        'code',
        'name',
        'description',
    ];

    public function app(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'app_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'granularity_role')
            ->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'granularity_user')
            ->withTimestamps();
    }
}
