<?php

use Illuminate\Support\Facades\Route;
use Modules\Cities\Http\Controllers\CityController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('cities', CityController::class);
});
