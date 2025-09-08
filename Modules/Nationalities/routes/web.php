<?php

use Illuminate\Support\Facades\Route;
use Modules\Nationalities\Http\Controllers\NationalityController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('nationalities', NationalityController::class);
});
