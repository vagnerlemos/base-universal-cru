<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//--------------------------------------------------------------------------
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //--------------------------------------------------------------------------
        /*
        |--------------------------------------------------------------------------
        | Blade Helpers - Granularidade
        |--------------------------------------------------------------------------
        | Estes helpers NÃO criam regras.
        | Eles apenas delegam para:
        | User::hasGranularityRestriction()
        |--------------------------------------------------------------------------
        */

        Blade::directive('denyGranularity', function ($expression) {
            return "<?php if(auth()->check() && auth()->user()->hasGranularityRestriction({$expression})): ?>";
        });

        Blade::directive('enddenyGranularity', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('allowGranularity', function ($expression) {
            return "<?php if(auth()->check() && !auth()->user()->hasGranularityRestriction({$expression})): ?>";
        });

        Blade::directive('endallowGranularity', function () {
            return "<?php endif; ?>";
        });
        /*
        |--------------------------------------------------------------------------
        | Blade Helpers - Permission
        |--------------------------------------------------------------------------
        | Estes helpers NÃO criam regras.
        | Eles apenas delegam para:
        | User::canPermission()
        |--------------------------------------------------------------------------
        */

        Blade::if('canPermission', function (string $permission, ?string $appCode = null) {
            /**
             * @var mixed
             */
            $user = auth()->user();

            if (! $user) {
                return false;
            }

            return $user->hasPermission($permission, $appCode);
        });
    }
}
