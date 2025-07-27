<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Página de bienvenida
Route::view('/', 'welcome');

// Dashboard (requiere autenticación y verificación)
Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    
    // Perfil de usuario
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Consultas
    Route::prefix('consultations')->name('consultations.')->group(function () {
        Route::get('create', [ConsultationController::class, 'create'])->name('create');
        Route::post('save-consultation-information', [ConsultationController::class, 'saveConsultationInformation'])->name('save_consultation_information');
    });

    // Doctores
    Route::prefix('doctors')->name('doctors.')->group(function () {
        Route::get('search-doctor-information', [DoctorController::class, 'searchDoctorInformation'])->name('search_doctor_information');
    });

    // Inventarios
    Route::prefix('inventories')->name('inventories.')->group(function () {
        Route::get('inventory-by-shift', [InventoryController::class, 'inventoryByShift'])->name('inventory_by_shift');
        Route::get('shift-management', [InventoryController::class, 'shiftManagement'])->name('shift_management');
        Route::get('restock-inventory', [InventoryController::class, 'restockInventory'])->name('restock_inventory');
        Route::get('get-inventory-request-information', [InventoryController::class, 'getInventoryRequestInformation'])->name('get_inventory_request_information');
        Route::get('get-inventory-information', [InventoryController::class, 'getInventoryInformation'])->name('get_inventory_information');
        Route::get('inventory-requisition', [InventoryController::class, 'inventoryRequisition'])->name('inventory_requisition');
        Route::post('save-shift-inventory-information', [InventoryController::class, 'saveShiftInventoryInformation'])->name('save_shift_inventory_information');
        Route::patch('update-inventory-stock', [InventoryController::class, 'updateInventoryStock'])->name('update_inventory_stock');
        Route::patch('update-shift-inventory-information', [InventoryController::class, 'updateShiftInventoryInformation'])->name('update_shift_inventory_information');
    });

    // Pacientes
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('search-patient-information', [PatientController::class, 'searchPatientInformation'])->name('search_patient_information');
    });

    // Productos
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('get-product-information', [ProductController::class, 'getProductInformation'])->name('get_product_information');
        Route::get('load-product-information', [ProductController::class, 'loadProductInformation'])->name('load_product_information');
        Route::get('search-product-information', [ProductController::class, 'searchProductInformation'])->name('search_product_information');
        Route::patch('update-product-stock', [ProductController::class, 'updateProductStock'])->name('update_product_stock');
    });

    // Turnos
    Route::prefix('shifts')->name('shifts.')->group(function () {
        Route::get('get-shift-information', [ShiftController::class, 'getShiftInformation'])->name('get_shift_information');
        Route::get('get-previous-shift-status', [ShiftController::class, 'getPreviousShiftStatus'])->name('get_previous_shift_status');
        Route::get('get-current-shift-status', [ShiftController::class, 'getCurrentShiftStatus'])->name('get_current_shift_status');
        Route::patch('update-shift-status', [ShiftController::class, 'updateShiftStatus'])->name('update_shift_status');
        Route::patch('update-previous-shift-status', [ShiftController::class, 'updatePreviousShiftStatus'])->name('update_previous_shift_status');
    });

    // Ventas
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('create', [SaleController::class, 'create'])->name('create');
        Route::get('sales-analysis', [SaleController::class, 'salesAnalysis'])->name('sales_analysis');
        Route::get('get-sale-information', [SaleController::class, 'getSaleInformation'])->name('get_sale_information');
        Route::get('get-sale-information-by-shift', [SaleController::class, 'getSaleInformationByShift'])->name('get_sale_information_by_shift');
        Route::post('save-sale-information', [SaleController::class, 'saveSaleInformation'])->name('save_sale_information');
    });
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

//Rutas de autenticación (Laravel Breeze)
require __DIR__.'/auth.php';