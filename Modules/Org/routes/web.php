<?php

use Illuminate\Support\Facades\Route;
use Modules\Org\Http\Controllers\CompanyController;
use Modules\Org\Http\Controllers\BranchController;
use Modules\Org\Http\Controllers\DepartmentController;
use Modules\Org\Http\Controllers\JobController;
use Modules\Org\Http\Controllers\NationalityController;
use Modules\Org\Http\Controllers\CityController;
use Modules\Org\Http\Controllers\ResidencyStatusController;
use Modules\Org\Http\Controllers\WorkStatusController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('jobs', JobController::class);
    Route::resource('nationalities', NationalityController::class);
    Route::resource('cities', CityController::class);
    Route::resource('residency-statuses', ResidencyStatusController::class);
    Route::resource('work-statuses', WorkStatusController::class);
});
