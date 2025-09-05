<?php

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\Setting\SettingController;

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

        Route::prefix('settings')->group(function () {
            Route::resource('settings', SettingController::class);
        });

        Route::resource('users', UserRoleController::class);
        Route::resource('nationalities', NationalityController::class);
        Route::resource('titles', TitleController::class);

    });

    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';


    
