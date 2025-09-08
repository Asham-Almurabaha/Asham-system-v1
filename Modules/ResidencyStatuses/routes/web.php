<?php

use Illuminate\Support\Facades\Route;
use Modules\ResidencyStatuses\Http\Controllers\ResidencyStatusController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('residency-statuses', ResidencyStatusController::class);
});
