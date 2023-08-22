<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
//projectscontrollers
Route::middleware(['auth'])->group(function () {
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectsController::class, 'create'])->name('projects.create');
    Route::get('/projects/{project:id}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project:id}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project:id}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::delete('projects/{project:id}', [ProjectsController::class, 'destroy'])->name('projects.destroy');
    //ajax
    Route::post('/projects/handle-selected-users', [ProjectsController::class, 'handleSelectedUsers'])->name('projects.handle.selected.users');
    Route::get('/fetch-roles', [RoleController::class, 'fetchRoles'])->name('roles.fetch');
});
//tasksController
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/{task:id}', [TasksController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task:id}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
    Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task:id}', [TasksController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/{task:id}', [TasksController::class, 'destroy'])->name('tasks.destroy');
    //ajax
    Route::post('tasks/chooseProject', [TasksController::class, 'chooseProject'])->name('tasks.chooseProject');
});
Auth::routes();
