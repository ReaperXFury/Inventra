<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GcashController;
use App\Http\Controllers\EloadController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SalesRecord;
use App\Http\Controllers\UtangController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{product}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{product}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    Route::get('/pos', [PosController::class, 'index'])->name('pos');
    Route::post('/pos', [PosController::class, 'store'])->name('pos');

    Route::get('/sale-record', [SalesRecord::class, 'index'])->name('sale-record');

    Route::get('/utang', [UtangController::class, 'index'])->name('utang.index');
    Route::post('/utang', [UtangController::class, 'store'])->name('utang.store');
    Route::put('/utang/{utang}', [UtangController::class, 'update'])->name('utang.update');
    Route::delete('/utang/{utang}', [UtangController::class, 'destroy'])->name('utang.destroy');


    Route::get('/gcash', [GcashController::class, 'index'])->name('gcash.index');
    Route::post('/gcash', [GcashController::class, 'store'])->name('gcash.store');
    Route::put('/gcash/{gcash}', [GcashController::class, 'update'])->name('gcash.update');
    Route::delete('/gcash/{gcash}', [GcashController::class, 'destroy'])->name('gcash.destroy');

    Route::get('/eload', [EloadController::class, 'index'])->name('eload.index');
    Route::post('/eload', [EloadController::class, 'store'])->name('eload.store');
    Route::put('/eload/{eload}', [EloadController::class, 'update'])->name('eload.update');
    Route::delete('/eload/{eload}', [EloadController::class, 'destroy'])->name('eload.destroy');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

