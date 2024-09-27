<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return to_route('login');
})->name('home');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.post');
Route::get('logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::match(['get', 'post'], 'register', [LoginController::class, 'register'])->name('register');
Route::middleware('auth')->prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('projects');
    Route::match(['get', 'post'], 'create', [ProjectController::class, 'create'])->name('projects.create');
    Route::match(['get', 'post'], '{project}/update', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('{project}/destroy', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::middleware([IsAdminMiddleware::class])->group(function () {
        Route::get('recycle-bin', [ProjectController::class, 'recycleBin'])->name('recycle-bin');
        Route::post('restore', [ProjectController::class, 'restore'])->name('projects.restore');
    });
});
