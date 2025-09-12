<?php

use Modules\Phones\Http\Controllers\PhoneController;
use Modules\Phones\Http\Controllers\PhoneAssignmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth'])->group(function () {
    Route::resource('phones', PhoneController::class);
    Route::post('phones/{phone}/assignments', [PhoneAssignmentController::class, 'store'])->name('phones.assignments.store');
    Route::post('phones/{phone}/assignments/{assignment}/return', [PhoneAssignmentController::class, 'return'])->name('phones.assignments.return');
    Route::get('phones/{phone}/assignments/history', [PhoneAssignmentController::class, 'history'])->name('phones.assignments.history');
});
