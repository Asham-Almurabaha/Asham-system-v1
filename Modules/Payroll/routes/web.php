<?php

use Illuminate\Support\Facades\Route;
use Modules\Payroll\Http\Controllers\PayrollRunController;
use Modules\Payroll\Http\Controllers\PayrollItemController;
use Modules\Payroll\Http\Controllers\WpsExportController;

Route::middleware(['web','auth'])->prefix('hr')->name('hr.')->group(function () {
    Route::resource('payroll-runs', PayrollRunController::class)->only(['index','create','store','show']);
    Route::post('payroll-runs/{run}/post', [PayrollRunController::class,'post'])->name('payroll.post');
    Route::post('payroll-runs/{run}/items', [PayrollItemController::class,'upsert'])->name('payroll.items.upsert');
    Route::get('payroll-runs/{run}/export-wps', [WpsExportController::class,'export'])->name('payroll.export_wps');
});
