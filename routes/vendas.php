<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Vendas\VendasController;

Route::prefix('vendas')
    ->middleware('context.access')
    ->group(function () {
        //get -> vendas/login -> showLoginForm
        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->defaults('app', 'vendas')
            ->name('vendas.login');

        //post -> vendas/login -> login (envio de email e senha)
        Route::post('/login', [LoginController::class, 'login'])
            ->defaults('app', 'vendas')
            ->name('vendas.login.submit');

        //get -> vendas/ -> index do aplicativo de vendas enta dentro
        Route::get('/', [VendasController::class, 'index'])
            ->defaults('app', 'vendas')
            ->name('vendas.dashboard');
    });
