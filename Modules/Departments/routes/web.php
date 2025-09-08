<?php

use Illuminate\Support\Facades\Route;
use Modules\Departments\Http\Controllers\DepartmentController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('departments', DepartmentController::class);
});
