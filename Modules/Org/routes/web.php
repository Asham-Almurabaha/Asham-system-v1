<?php

use Illuminate\Support\Facades\Route;
use Modules\Org\Http\Controllers\CompanyController;
use Modules\Org\Http\Controllers\BranchController;
use Modules\Org\Http\Controllers\DepartmentController;
use Modules\Org\Http\Controllers\JobController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('jobs', JobController::class);
});
