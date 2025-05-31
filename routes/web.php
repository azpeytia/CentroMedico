<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    // Region inventarios
    Route::get('/inventories/shift-management', [InventoryController::class, 'shiftManagement'])->name('inventories.shift_management');
    Route::get('/inventories/get-inventory-request-information', [InventoryController::class, 'getInventoryRequestInformation'])->name('inventories.get_inventory_request_information');
    Route::get('/inventories/get-inventory-information', [InventoryController::class, 'getInventoryInformation'])->name('inventories.get_inventory_information');
    Route::post('/inventories/save-shift-inventory-information', [InventoryController::class, 'saveShiftInventoryInformation'])->name('inventories.save_shift_inventory_information');
    Route::patch('/inventories/update-shift-inventory-information', [InventoryController::class, 'updateShiftInventoryInformation'])->name('inventories.update_shift_inventory_information');
    // Endregion inventarios

    // Region pacientes
    Route::get('/patients/search-patient-information', [PatientController::class, 'searchPatientInformation'])->name('patients.search_patient_information');
    // Endregion pacientes

    // Region productos
    Route::get('/products/get-product-information', [ProductController::class, 'getProductInformation'])->name('products.get_product_information');
    Route::get('/products/search-product-information', [ProductController::class, 'searchProductInformation'])->name('products.search_product_information');
    // Endregion productos

    // Region turnos
    Route::get('/shifts/get-shift-information', [ShiftController::class, 'getShiftInformation'])->name('shifts.get_shift_information');
    Route::get('/shifts/get-previous-shift-status', [ShiftController::class, 'getPreviousShiftStatus'])->name('shifts.get_previous_shift_status');
    Route::get('/shifts/get-current-shift-status', [ShiftController::class, 'getCurrentShiftStatus'])->name('shifts.get_current_shift_status');
    Route::patch('/shifts/update-shift-status', [ShiftController::class, 'updateShiftStatus'])->name('shifts.update_shift_status');
    Route::patch('/shifts/update-previous-shift-status', [ShiftController::class, 'updatePreviousShiftStatus'])->name('shifts.update_previous_shift_status');
    // Endregion turnos

    // Region ventas
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales/save-sale-information', [SaleController::class, 'saveSaleInformation'])->name('sales.save_sale_information');
    // Endregion ventas
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';