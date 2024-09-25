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
Route::middleware([IsAdminMiddleware::class])->group(function () {
    Route::get('projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('projects/create', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::post('projects/{project}/edit', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('projects/{project}/destroy', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::get('projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
    Route::get('projects/{project}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.force-delete');
    Route::get('projects/{project}/restore-all', [ProjectController::class, 'restoreAll'])->name('projects.restore-all');
    Route::get('projects/{project}/force-delete-all', [ProjectController::class, 'forceDeleteAll'])->name('projects.force-delete-all');
    Route::get('projects/{project}/show-all', [ProjectController::class, 'showAll'])->name('projects.show-all');
    
    Route::get('recycle-bin', [ProjectController::class, 'recycleBin'])->name('recycle-bin');
});
