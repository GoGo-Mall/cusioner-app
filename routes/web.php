<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\RespondentController;
use App\Http\Controllers\HomeController;
// use App\Models\Respondent;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/store', [HomeController::class, 'store'])->name('cusioner.store');

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('quest', QuestionController::class);
    Route::resource('respon', RespondentController::class);
});
