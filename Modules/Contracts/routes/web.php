<?php

use Illuminate\Support\Facades\Route;
use Modules\Contracts\Http\Controllers\ContractController;

Route::middleware(['web','auth'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('employees/{employee}/contracts', [ContractController::class,'index'])->name('employees.contracts.index');
    Route::get('employees/{employee}/contracts/create', [ContractController::class,'create'])->name('employees.contracts.create');
    Route::post('employees/{employee}/contracts', [ContractController::class,'store'])->name('employees.contracts.store');
    Route::delete('contracts/{contract}', [ContractController::class,'destroy'])->name('contracts.destroy');
});
