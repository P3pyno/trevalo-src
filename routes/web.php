<?php

use Illuminate\Support\Facades\Route;

// All non-API routes are handled by the Vue SPA
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api).*');
