<?php

use Illuminate\Support\Facades\Route;



//site------------------------------------------------------------------
Route::get('/', function () {
    return view('site.home');
})->name('site.home');

Route::get('/sobre', function () {
    return view('site.sobre');
})->name('site.sobre');

Route::get('/contato', function () {
    return view('site.contato');
})->name('site.contato');
