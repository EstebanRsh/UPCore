<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceAddressController;
use App\Http\Controllers\ContractController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:manager'])->group(function () {
        Route::resource('planes', PlanController::class);
        Route::get('/approvals', [UserApprovalController::class, 'index'])->name('admin.approvals.index');
        Route::patch('/approvals/{user}', [UserApprovalController::class, 'approve'])->name('admin.approvals.approve');
        Route::delete('/approvals/{user}', [UserApprovalController::class, 'reject'])->name('admin.approvals.reject');
        Route::resource('clients', ClientController::class);

        // <-- 2. AÑADIR ESTE BLOQUE DE RUTAS -->
        Route::get('/clients/{client}/addresses/create', [ServiceAddressController::class, 'create'])->name('clients.addresses.create');
        Route::post('/clients/{client}/addresses', [ServiceAddressController::class, 'store'])->name('clients.addresses.store');
        Route::get('/clients/{client}/addresses/{address}/edit', [ServiceAddressController::class, 'edit'])->name('clients.addresses.edit');
        Route::patch('/clients/{client}/addresses/{address}', [ServiceAddressController::class, 'update'])->name('clients.addresses.update');
        Route::delete('/clients/{client}/addresses/{address}', [ServiceAddressController::class, 'destroy'])->name('clients.addresses.destroy');
        Route::get('/clients/{client}/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
        Route::post('/clients/{client}/contracts', [ContractController::class, 'store'])->name('contracts.store');
    });
});

require __DIR__ . '/auth.php';
