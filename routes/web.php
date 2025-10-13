<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdLookupController;
use App\Http\Controllers\AddressController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index']); // Redirige la raíz a dashboard si está logueado
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Lookup cedula (demo)
Route::post('lookup-id', [IdLookupController::class, 'lookup'])->name('lookup-id');

// Address AJAX endpoints (demo)
Route::get('address/states', [AddressController::class, 'states'])->name('address.states');
Route::post('address/municipalities', [AddressController::class, 'municipalities'])->name('address.municipalities');
Route::post('address/parishes', [AddressController::class, 'parishes'])->name('address.parishes');
Route::post('address/communes', [AddressController::class, 'communes'])->name('address.communes');