<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DisposableController;
use App\Http\Controllers\RpcppeController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\PPERecapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root route - redirect to LOGIN
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth protected routes
Route::middleware(['auth', 'verified'])->group(function () {

    // ✅ Dashboard (NOW PROTECTED)
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    /*
    |=====================================================
    | DISPOSABLE ROUTES
    |=====================================================
    */
    Route::get('/disposable/export-pdf', [DisposableController::class, 'exportPDF'])->name('disposable.pdf');
    Route::get('/disposable/export-excel', [DisposableController::class, 'exportExcel'])->name('disposable.excel');
    Route::resource('disposable', DisposableController::class);

    /*
    |=====================================================
    | PROFILE ROUTES
    |=====================================================
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |=====================================================
    | RPCPPE ROUTES
    |=====================================================
    */
    Route::prefix('rpcppe')->name('rpcppe.')->group(function () {
    // Main CRUD
    Route::get('/', [RpcppeController::class, 'index'])->name('index');
    Route::get('/create', [RpcppeController::class, 'create'])->name('create');
    Route::post('/', [RpcppeController::class, 'store'])->name('store');
    
    Route::get('/{id}/edit', [RpcppeController::class, 'edit'])->whereNumber('id')->name('edit');
    Route::put('/{id}', [RpcppeController::class, 'update'])->whereNumber('id')->name('update');
    Route::delete('/{id}', [RpcppeController::class, 'destroy'])->whereNumber('id')->name('destroy');

    // Reports & Tools
    Route::get('/print/table', [RpcppeController::class, 'printTable'])->name('print.table');
    Route::get('/print/filtered', [RpcppeController::class, 'printFilteredTable'])->name('print.filtered');
    Route::get('/reports/appendix73', [RpcppeController::class, 'appendix73'])->name('reports.appendix73');
    Route::post('/import', [RpcppeController::class, 'importExcel'])->name('import');

    // ✅ ILIPAT DITO SA LOOB ANG EXPORT ROUTES:
    Route::get('/reports/appendix73/export', [RpcppeController::class, 'appendix73Export'])
        ->name('reports.appendix73.export');

    Route::get('/export/excel', [RpcppeController::class, 'exportExcel'])
        ->name('export.excel');
});
/*
    |=====================================================
    | RECORD ROUTES
    |=====================================================
    */
    Route::get('/records', [RecordController::class, 'index'])->name('records.index');
    Route::delete('/records/{record}', [RecordController::class, 'destroy'])->name('records.destroy');
    Route::get('/records/{record}/pdf', [RecordController::class, 'pdf'])->name('records.pdf');
    Route::get('/records/{record}/excel', [RecordController::class, 'excel'])->name('records.excel');
    Route::get('/records/inventory-storage', [RecordController::class, 'inventoryStorage'])->name('records.inventory_storage');
    Route::get('/records/export-folder', [RecordController::class, 'exportFolder'])->name('records.export_folder');


    /*
    |=====================================================
    | PPE RECAP ROUTES
    |=====================================================
    */
    Route::prefix('ppe-recap')->name('ppe-recap.')->group(function () {

        Route::get('/', [PPERecapController::class, 'index'])->name('index');
        Route::get('/{year}', [PPERecapController::class, 'preview'])->whereNumber('year')->name('preview');
        Route::get('/{year}/pdf', [PPERecapController::class, 'pdf'])->whereNumber('year')->name('pdf');
        Route::get('/{year}/excel', [PPERecapController::class, 'excel'])->whereNumber('year')->name('excel');
        Route::post('/store', [PPERecapController::class, 'store'])->name('store');
       
    
    }); 
    });


// Auth routes
require __DIR__ . '/auth.php';
