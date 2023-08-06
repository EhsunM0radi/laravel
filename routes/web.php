<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', DashboardController::class)->name('dashboard');
//projectscontrollers
Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectsController::class, 'create'])->name('projects.create');
Route::get('/projects/{id}', [ProjectsController::class, 'show'])->name('projects.show');
Route::get('/projects/{id}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
Route::put('/projects/{id}', [ProjectsController::class, 'update'])->name('projects.update');
Route::delete('projects/{id}', [ProjectsController::class, 'delete'])->name('projects.delete');
//tasksController
Route::get('/tasks/create', [tasksController::class, 'create'])->name('tasks.create');
Route::get('/tasks/{id}', [tasksController::class, 'show'])->name('tasks.show');
Route::get('/tasks/{id}/edit', [tasksController::class, 'edit'])->name('tasks.edit');
Route::post('/tasks', [tasksController::class, 'store'])->name('tasks.store');
Route::put('/tasks/{id}', [tasksController::class, 'update'])->name('tasks.update');
Route::delete('tasks/{id}', [tasksController::class, 'delete'])->name('tasks.delete');
