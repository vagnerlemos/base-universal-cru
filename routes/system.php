<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\System\SystemController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\ClientController;
use App\Http\Controllers\System\ApplicationController;
use App\Http\Controllers\System\PermissionController;
use App\Http\Controllers\System\GranularityController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\System\ActivityLogController;

Route::prefix('system')
    ->middleware('context.access')
    ->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Login - SYSTEM
        |--------------------------------------------------------------------------
        */

        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->defaults('app', 'system')
            ->name('system.login');

        Route::post('/login', [LoginController::class, 'login'])
            ->defaults('app', 'system')
            ->name('system.login.submit');
        /*
        |--------------------------------------------------------------------------
        | Dashboard - SYSTEM
        |--------------------------------------------------------------------------
        */

        Route::get('/', [SystemController::class, 'index'])
            ->defaults('app', 'system')
            ->name('system.dashboard');

        /*
        |--------------------------------------------------------------------------
        | Governança - Usuários (CRUD livre por enquanto)
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [UserController::class, 'index'])
            ->defaults('app', 'system')
            ->name('system.users.index');

        Route::get('/users/create', [UserController::class, 'create'])
            ->defaults('app', 'system')
            ->name('system.users.create');

        Route::post('/users', [UserController::class, 'store'])
            ->defaults('app', 'system')
            ->name('system.users.store');

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->defaults('app', 'system')
            ->name('system.users.edit');

        Route::put('/users/{user}', [UserController::class, 'update'])
            ->defaults('app', 'system')
            ->name('system.users.update');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->defaults('app', 'system')
            ->name('system.users.destroy');



        //-------------------------------------------------------------------------------------
        // CRUD Clientes (somente /system)
        Route::get('/clients', [ClientController::class, 'index'])->middleware('permission:clients.view')
            ->defaults('app', 'system')
            ->name('system.clients.index');

        Route::get('/clients/create', [ClientController::class, 'create'])->middleware('permission:clients.create')
            ->defaults('app', 'system')
            ->name('system.clients.create');

        Route::post('/clients', [ClientController::class, 'store'])->middleware('permission:clients.create')
            ->defaults('app', 'system')
            ->name('system.clients.store');

        Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->middleware('permission:clients.update')
            ->defaults('app', 'system')
            ->name('system.clients.edit');

        Route::put('/clients/{client}', [ClientController::class, 'update'])->middleware('permission:clients.update')
            ->defaults('app', 'system')
            ->name('system.clients.update');

        Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->middleware('permission:clients.delete')
            ->defaults('app', 'system')
            ->name('system.clients.destroy');
        //-------------------------------------------------------------------------------------
        // APPS (novo)
        Route::get('/apps', [ApplicationController::class, 'index'])->defaults('app', 'system')->name('system.apps.index');
        Route::get('/apps/{application}/edit', [ApplicationController::class, 'edit'])->defaults('app', 'system')->name('system.apps.edit');
        Route::put('/apps/{application}', [ApplicationController::class, 'update'])->defaults('app', 'system')->name('system.apps.update');
        // Permissions (edição controlada)
        Route::get('/permissions', [PermissionController::class, 'index'])->defaults('app', 'system')
            ->name('system.permissions.index');

        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->defaults('app', 'system')
            ->name('system.permissions.edit');

        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->defaults('app', 'system')
            ->name('system.permissions.update');


        // Granularidades (edição controlada)
        Route::get('/granularities', [GranularityController::class, 'index'])->defaults('app', 'system')
            ->name('system.granularities.index');

        Route::get('/granularities/{granularity}/edit', [GranularityController::class, 'edit'])->defaults('app', 'system')
            ->name('system.granularities.edit');

        Route::put('/granularities/{granularity}', [GranularityController::class, 'update'])->defaults('app', 'system')
            ->name('system.granularities.update');

        // Roles
        Route::get('/roles', [RoleController::class, 'index'])->defaults('app', 'system')->name('system.roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->defaults('app', 'system')->name('system.roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->defaults('app', 'system')->name('system.roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->defaults('app', 'system')->name('system.roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->defaults('app', 'system')->name('system.roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->defaults('app', 'system')->name('system.roles.destroy');



        // Log de atividades
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->defaults('app', 'system')
            ->name('system.activity_logs.index');

        Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->defaults('app', 'system')
            ->name('system.activity_logs.show');
    });

// Logout global (fora do contexto de app)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
