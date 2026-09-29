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

    // ✅ Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    /*
    |=====================================================
    | DISPOSABLE ROUTES
    |=====================================================
    |*/
    Route::get('/disposable/export-pdf', [DisposableController::class, 'exportPDF'])->name('disposable.exportPDF');
    Route::get('/disposable/export-excel', [DisposableController::class, 'exportExcel'])->name('disposable.exportExcel');
    Route::resource('disposable', DisposableController::class);
    Route::post('/disposable/{id}/restore', [DisposableController::class, 'restore'])->name('disposable.restore');

    /*
    |=====================================================
    | PROFILE ROUTES
    |=====================================================
    |*/
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
|=====================================================
| RPCPPE ROUTES
|=====================================================
|*/
Route::prefix('rpcppe')->name('rpcppe.')->group(function () {
    Route::get('/', [RpcppeController::class, 'index'])->name('index');
    Route::get('/create', [RpcppeController::class, 'create'])->name('create');
    Route::post('/', [RpcppeController::class, 'store'])->name('store');
    
    // Ginamit ang {rpcppe} para sa Laravel Route Model Binding
    Route::get('/{rpcppe}', [RpcppeController::class, 'show'])->name('show');
    Route::get('/{rpcppe}/edit', [RpcppeController::class, 'edit'])->name('edit');
    Route::put('/{rpcppe}', [RpcppeController::class, 'update'])->name('update');
    Route::delete('/{rpcppe}', [RpcppeController::class, 'destroy'])->name('destroy');
    
    // Bulk Destroy / Move to Disposables
    Route::post('/bulk-destroy', [RpcppeController::class, 'bulkDestroy'])->name('bulkDestroy');

    // Excel Import & Export Routes
    Route::post('/import', [RpcppeController::class, 'importExcel'])->name('import');
    Route::get('/export/excel', [RpcppeController::class, 'exportExcel'])->name('export.excel');

    // Reports & Appendix 73
    Route::get('/reports/appendix73', [RpcppeController::class, 'appendix73'])->name('reports.appendix73');
    Route::get('/reports/appendix73/export', [RpcppeController::class, 'appendix73Export'])->name('reports.appendix73.export');

    // Print Routes
    Route::get('/print/table', [RpcppeController::class, 'printTable'])->name('print.table');
    Route::get('/print/filtered', [RpcppeController::class, 'printFilteredTable'])->name('print.filtered');

    // Archive Routes
    Route::get('/archive', [RpcppeController::class, 'archiveIndex'])->name('archive.index');
    Route::get('/archive/folder/{classification}', [RpcppeController::class, 'archiveFolder'])->name('archive.folder');
});
    /*
    |=====================================================
    | RECORD ROUTES (Updated with Export Filtered and Folder Repo)
    |=====================================================
    |*/
     Route::get('/records', [RecordController::class, 'index'])->name('records.index');
    Route::delete('/records/{record}', [RecordController::class, 'destroy'])->name('records.destroy');
    Route::get('/records/{record}/pdf', [RecordController::class, 'pdf'])->name('records.pdf');
    Route::get('/records/{record}/excel', [RecordController::class, 'excel'])->name('records.excel');
    Route::get('/records/inventory-storage', [RecordController::class, 'inventoryStorage'])->name('records.inventory_storage');
    Route::get('/records/export-folder', [RecordController::class, 'exportFolder'])->name('records.export_folder');
    Route::get('/records/export-filtered', [RecordController::class, 'exportFiltered'])->name('records.export_filtered');

    /*
    |=====================================================
    | PPE RECAP ROUTES
    |=====================================================
    |*/
    Route::prefix('ppe-recap')->name('ppe-recap.')->group(function () {
        Route::get('/', [PPERecapController::class, 'index'])->name('index');
        Route::get('/{year}', [PPERecapController::class, 'preview'])->whereNumber('year')->name('preview');
        Route::get('/{year}/pdf', [PPERecapController::class, 'pdf'])->whereNumber('year')->name('pdf');
        Route::get('/{year}/excel', [PPERecapController::class, 'excel'])->whereNumber('year')->name('excel');
        Route::post('/store', [PPERecapController::class, 'store'])->name('store');
    }); 
});

require __DIR__ . '/auth.php';