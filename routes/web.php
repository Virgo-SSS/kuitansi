<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => redirect()->route('login'));

Route::middleware([ 'auth', config('jetstream.auth_session')])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(ReceiptController::class)->prefix('receipt')->group(function () {
        Route::get('/create','create')->name('receipt.create');
        Route::post('/','store')->name('receipt.store');
        Route::get('/{receipt}','edit')->name('receipt.edit');
        Route::put('/{receipt}','update')->name('receipt.update');
    });

    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('/create', 'create')->name('user.create');
        Route::post('/', 'store')->name('user.store');
    });

    Route::controller(RolePermissionController::class)->prefix('role')->group(function () {
        Route::get('/', 'index')->name('role.index');
        Route::get('/create', 'create')->name('role.create');
        Route::post('/', 'store')->name('role.store');
        Route::get('/{role}/edit', 'edit')->name('role.edit');
        Route::put('/{role}', 'update')->name('role.update');
    });

    Route::controller(ProjectController::class)->prefix('project')->group(function () {
        Route::get('/', 'index')->name('project.index');
        Route::get('/create', 'create')->name('project.create');
        Route::post('/', 'store')->name('project.store');
        Route::get('/{project}/edit', 'edit')->name('project.edit');
        Route::put('/{project}', 'update')->name('project.update');
        Route::delete('/{project}', 'destroy')->name('project.destroy');
    });
});
