<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\SettingController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('settings', SettingController::class)->names('settings');
});
