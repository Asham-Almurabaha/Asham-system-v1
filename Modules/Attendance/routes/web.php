<?php

use Illuminate\Support\Facades\Route;
use Modules\Attendance\Http\Controllers\ShiftController;
use Modules\Attendance\Http\Controllers\ScheduleController;
use Modules\Attendance\Http\Controllers\AttendanceController;
use Modules\Attendance\Http\Controllers\OvertimeRequestController;

Route::middleware(['web','auth'])->prefix('hr')->name('hr.')->group(function () {
    Route::resource('shifts', ShiftController::class);

    Route::get('employees/{employee}/schedules', [ScheduleController::class,'index'])->name('employees.schedules.index');
    Route::post('employees/{employee}/schedules', [ScheduleController::class,'store'])->name('employees.schedules.store');
    Route::put('employees/{employee}/schedules/{schedule}', [ScheduleController::class,'update'])->name('employees.schedules.update');

    Route::resource('attendances', AttendanceController::class)->only(['index','store']);

    Route::get('overtime', [OvertimeRequestController::class,'index'])->name('overtime.index');
    Route::get('overtime/create', [OvertimeRequestController::class,'create'])->name('overtime.create');
    Route::post('overtime', [OvertimeRequestController::class,'store'])->name('overtime.store');
    Route::post('overtime/{overtime}/approve', [OvertimeRequestController::class,'approve'])->name('overtime.approve');
    Route::post('overtime/{overtime}/reject', [OvertimeRequestController::class,'reject'])->name('overtime.reject');
});
