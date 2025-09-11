<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth'])->prefix('hr')->name('hr.')->group(function () {
    // TODO: attendance routes
});
