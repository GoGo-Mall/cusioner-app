<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\RespondentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (kuesioner publik)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/store', [HomeController::class, 'store'])->name('cusioner.store');

// Auth routes (login/logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (hanya untuk role: admin)
Route::prefix('admin')
    ->middleware('role:admin,user')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('quest', QuestionController::class);
        Route::resource('respon', RespondentController::class);
    });

