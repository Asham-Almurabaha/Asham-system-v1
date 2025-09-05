<?php

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Setting\SettingController;

// لغة الواجهة
Route::post('/lang/toggle', [LanguageController::class, 'toggle'])->name('lang.toggle');
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// الصفحة الرئيسية (لو مفيش يوزر يوجّه للتسجيل، غير كده تسجيل الدخول)
Route::get('/', function () {
    return User::count() == 0 ? redirect()->route('register') : redirect()->route('login'); });

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return Setting::count() > 0 ? redirect()->route('dashboard') : redirect()->route('settings.create'); })->name('home');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // الإعدادات
    Route::prefix('settings')->group(function () {
        Route::resource('settings', SettingController::class);
    });


    // // البروفايل
    // Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ إدارة أدوار المستخدمين (محمية بدور admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users',               [UserRoleController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/roles',  [UserRoleController::class, 'edit'])->name('users.roles.edit');
        Route::put('/users/{user}/roles',  [UserRoleController::class, 'update'])->name('users.roles.update');
    });
});

require __DIR__.'/auth.php';