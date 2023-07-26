<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReceiptController;
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

Route::middleware([ 'auth:sanctum', config('jetstream.auth_session')])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/receipt/create', [ReceiptController::class, 'create'])->name('receipt.create');
    Route::post('/receipt', [ReceiptController::class, 'store'])->name('receipt.store');
    Route::get('/receipt/{receipt}', [ReceiptController::class, 'edit'])->name('receipt.edit');
    Route::put('/receipt/{receipt}', [ReceiptController::class, 'update'])->name('receipt.update');
});
