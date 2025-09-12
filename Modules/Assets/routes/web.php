<?php

use Illuminate\Support\Facades\Route;
use Modules\Assets\Http\Controllers\AssetController;
use Modules\Assets\Http\Controllers\AssetAssignmentController;

Route::middleware(['web','auth'])->prefix('hr')->name('hr.')->group(function () {
    Route::resource('assets', AssetController::class);
    Route::post('assets/{asset}/assign', [AssetAssignmentController::class,'store'])->name('assets.assign');
    Route::post('assets/{asset}/return', [AssetAssignmentController::class,'return'])->name('assets.return');
});
