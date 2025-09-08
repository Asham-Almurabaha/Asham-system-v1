<?php

use App\Models\User;
use Modules\Settings\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\AuditLogController;

Route::post('/lang/toggle', [LanguageController::class, 'toggle'])->name('lang.toggle');
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', function () {
    return User::count() == 0 ? redirect()->route('register') : redirect()->route('login'); 
});

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return Setting::count() > 0 ? redirect()->route('dashboard') : redirect()->route('settings.create'); })->name('home');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    Route::middleware(['role:admin'])->group(function () {

        Route::resource('users', UserRoleController::class);
        Route::resource('titles', TitleController::class);
        Route::resource('cities', CityController::class);
        Route::resource('branches', BranchController::class);
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
        Route::post('audit-logs/{auditLog}/revert', [AuditLogController::class, 'revert'])->name('audit-logs.revert');

    });

    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';


    
