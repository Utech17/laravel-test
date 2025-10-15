<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CuidadanoController;
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
Route::post('register/lookup', [RegisterController::class, 'lookupCedula'])->name('register.lookup');

// Lookup cedula (demo) - allow GET /lookup-id/{cedula} used by frontend JS and also POST if needed
Route::get('lookup-id/{cedula}', [CuidadanoController::class, 'FindOne'])->name('lookup-id.get');
Route::post('lookup-id', [CuidadanoController::class, 'FindOne'])->name('lookup-id');

// Address AJAX endpoints (demo)
Route::get('address/states', [AddressController::class, 'states'])->name('address.states');
Route::post('address/municipalities', [AddressController::class, 'municipalities'])->name('address.municipalities');
Route::post('address/parishes', [AddressController::class, 'parishes'])->name('address.parishes');
Route::post('address/communes', [AddressController::class, 'communes'])->name('address.communes');
Route::get('address/communes-list', [AddressController::class, 'communesList'])->name('address.communes.list');