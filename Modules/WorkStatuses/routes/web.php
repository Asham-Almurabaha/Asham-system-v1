<?php

use Illuminate\Support\Facades\Route;
use Modules\WorkStatuses\Http\Controllers\WorkStatusController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('work-statuses', WorkStatusController::class);
});
