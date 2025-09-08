<?php

use App\Models\User;
use Modules\Settings\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;

Route::post('/lang/toggle', [LanguageController::class, 'toggle'])->name('lang.toggle');
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', function () {
    return User::count() == 0 ? redirect()->route('register') : redirect()->route('login');
});

Route::get('/loading', function () {return view('loading');})->name('loading');

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return Setting::count() > 0 ? redirect()->route('dashboard') : redirect()->route('settings.create'); })->name('home');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    Route::middleware(['role:admin'])->group(function () {

        Route::resource('users', UserRoleController::class);
    });
});

require __DIR__.'/auth.php';


    
