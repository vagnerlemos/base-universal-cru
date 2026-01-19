<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'app_id',
        'code',
        'name',
        'description',
    ];

    /**
     * App ao qual a role pertence (system, vendas, etc)
     */
    public function app(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'app_id');
    }

    /**
     * Permissions positivas da role
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_role'
        )->withTimestamps();
    }

    /**
     * Granularidades (negações) da role
     */
    public function granularities(): BelongsToMany
    {
        return $this->belongsToMany(
            Granularity::class,
            'granularity_role'
        )->withTimestamps();
    }

    /**
     * Usuários que possuem esta role
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'role_user'
        )->withTimestamps();
    }
}
