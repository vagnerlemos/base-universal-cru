<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//---------------------------------------------------------------------------------------------------------
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Granularity;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];




    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'app_user', 'user_id', 'app_id')
            ->withTimestamps();
    }

    /**
     * RBAC
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * Verifica permissão pelo código (ex: users.view) no app atual.
     * - appCode padrão: route('app') se existir, senão 'system'
     */
    public function hasPermission(string $permissionCode, ?string $appCode = null): bool
    {
        $appCode = $appCode ?: (string) (request()->route('app') ?? 'system');

        $appId = $this->resolveAppIdByCode($appCode);
        if (!$appId) {
            return false;
        }

        return $this->roles()
            ->where('roles.app_id', $appId)
            ->whereHas('permissions', function ($q) use ($permissionCode, $appId) {
                $q->where('permissions.app_id', $appId)
                    ->where('permissions.code', $permissionCode);
            })
            ->exists();
    }

    /**
     * Verifica se o usuário TEM RESTRIÇÃO de granularidade
     * Retorna TRUE se estiver NEGADO
     */
    public function hasGranularityRestriction(string $granularityCode, ?string $appCode = null): bool
    {
        $appCode = $appCode ?: (string) (request()->route('app') ?? 'system');

        $appId = $this->resolveAppIdByCode($appCode);
        if (!$appId) {
            return false;
        }

        // 1) Restrição direta no usuário
        $direct = Granularity::query()
            ->where('app_id', $appId)
            ->where('code', $granularityCode)
            ->whereHas('users', fn($q) => $q->where('users.id', $this->id))
            ->exists();

        if ($direct) {
            return true;
        }

        // 2) Restrição via role
        return Granularity::query()
            ->where('app_id', $appId)
            ->where('code', $granularityCode)
            ->whereHas('roles', function ($q) use ($appId) {
                $q->where('roles.app_id', $appId)
                    ->whereIn('roles.id', $this->roles->pluck('id'));
            })
            ->exists();
    }

    private function resolveAppIdByCode(string $code): ?int
    {
        static $cache = [];

        if (array_key_exists($code, $cache)) {
            return $cache[$code];
        }

        $app = Application::query()->where('code', $code)->first();
        $cache[$code] = $app?->id;

        return $cache[$code];
    }

    // Granularidades diretas (negações)
    public function granularities()
    {
        return $this->belongsToMany(Granularity::class, 'granularity_user')
            ->withTimestamps();
    }
}
