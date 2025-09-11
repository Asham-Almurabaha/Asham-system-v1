<?php

use Illuminate\Support\Facades\Route;
use Modules\Contracts\Http\Controllers\ContractController;

Route::middleware(['web','auth'])->prefix('hr')->name('hr.')->group(function () {
    // TODO: refine routes
    Route::resource('contracts', ContractController::class)->parameters(['contracts' => 'contract']);
});
