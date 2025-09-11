<?php

use Illuminate\Support\Facades\Route;
use Modules\Documents\Http\Controllers\EmployeeDocumentController;

Route::middleware(['web','auth'])->group(function () {
    Route::post('hr/employees/{employee}/documents', [EmployeeDocumentController::class, 'store'])->name('hr.employees.documents.store');
    Route::delete('hr/documents/{document}', [EmployeeDocumentController::class, 'destroy'])->name('hr.documents.destroy');
});
