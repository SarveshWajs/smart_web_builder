<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ComponentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [ProjectController::class, 'index'])->name('home');

// Authenticated users only
Route::middleware(['auth'])->group(function () {
    Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/preview', [ProjectController::class, 'preview'])->name('projects.preview');
    Route::get('/projects/{project}/download', [ProjectController::class, 'download'])->name('projects.download');
    Route::post('/projects/{project}/favorite', [ProjectController::class, 'favorite'])->name('projects.favorite');
    Route::delete('/projects/{project}/favorite', [ProjectController::class, 'unfavorite'])->name('projects.unfavorite');
    Route::get('/favorites', [ProjectController::class, 'favorites'])->name('projects.favorites')->middleware('auth');
    Route::get('/my-templates', [ProjectController::class, 'myTemplates'])->name('projects.myTemplates')->middleware('auth');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{id}/share', [ProjectController::class, 'share'])->name('project.share');
    Route::get('/shared/{id}', [ProjectController::class, 'viewShared'])->name('project.shared.view');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');


});

// Admin-only section
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('themes', ThemeController::class);
    Route::resource('component', ComponentController::class);
    Route::patch('/themes/{theme}/toggle', [ThemeController::class, 'toggle'])->name('themes.toggle');
    Route::patch('/components/{component}/toggle', [ComponentController::class, 'toggle'])->name('components.toggle');
    Route::delete('/component/{component}/image', [ComponentController::class, 'deleteImage'])->name('component.image.delete');

});

require __DIR__.'/auth.php';
