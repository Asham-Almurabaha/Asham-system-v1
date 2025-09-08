<?php

use Illuminate\Support\Facades\Route;
use Modules\AuditLogs\Http\Controllers\AuditLogController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    Route::post('audit-logs/{auditLog}/revert', [AuditLogController::class, 'revert'])->name('audit-logs.revert');
});
