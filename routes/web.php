<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceAddressController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromotionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'role:manager'])->group(function () {
    // Gestiones Principales
    Route::resource('planes', PlanController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('contracts', ContractController::class)->except(['create', 'store']);

    // Aprobaciones
    Route::get('/approvals', [UserApprovalController::class, 'index'])->name('admin.approvals.index');
    Route::patch('/approvals/{user}', [UserApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::delete('/approvals/{user}', [UserApprovalController::class, 'reject'])->name('admin.approvals.reject');

    // Direcciones de Cliente
    Route::get('/clients/{client}/addresses/create', [ServiceAddressController::class, 'create'])->name('clients.addresses.create');
    Route::post('/clients/{client}/addresses', [ServiceAddressController::class, 'store'])->name('clients.addresses.store');
    Route::get('/clients/{client}/addresses/{address}/edit', [ServiceAddressController::class, 'edit'])->name('clients.addresses.edit');
    Route::patch('/clients/{client}/addresses/{address}', [ServiceAddressController::class, 'update'])->name('clients.addresses.update');
    Route::delete('/clients/{client}/addresses/{address}', [ServiceAddressController::class, 'destroy'])->name('clients.addresses.destroy');

    // Contratos de Cliente
    Route::get('/clients/{client}/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/clients/{client}/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::patch('/contracts/{contract}/status', [ContractController::class, 'updateStatus'])->name('contracts.updateStatus');

    // Facturación y Pagos
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/{client}/create-invoice', [BillingController::class, 'createInvoice'])->name('billing.createInvoice');
    Route::post('/billing/{client}/store-invoice', [BillingController::class, 'storeInvoice'])->name('billing.storeInvoice');
    Route::get('/invoices/{invoice}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/invoices/{invoice}', [PaymentController::class, 'store'])->name('payments.store');
});

require __DIR__ . '/auth.php';
