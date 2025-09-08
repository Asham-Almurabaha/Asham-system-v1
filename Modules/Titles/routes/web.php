<?php

use Illuminate\Support\Facades\Route;
use Modules\Titles\Http\Controllers\TitleController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('titles', TitleController::class);
});
