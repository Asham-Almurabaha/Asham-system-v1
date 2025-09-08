<?php

use Illuminate\Support\Facades\Route;
use Modules\Branches\Http\Controllers\BranchController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('branches', BranchController::class);
});
