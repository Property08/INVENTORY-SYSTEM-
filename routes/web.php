<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DisposableController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\RpcppeController;

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    // Disposable
    Route::resource('disposable', DisposableController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------- RECAP ----------
    // ✅ Plain recap.* routes (recap.index, recap.create, etc.)
    Route::resource('recap', RecapController::class);
    Route::get('/recap/print/pdf',[RecapController::class, 'printPdf'])->name('recap.print.pdf');

    /*
    |=====================================================
    | RPCPPE ROUTES
    |=====================================================
    */
    Route::prefix('rpcppe')->name('rpcppe.')->group(function () {

        // ---------- CRUD ----------
        Route::get('/print/filtered', [RpcppeController::class, 'printFilteredTable'])->name('print.filtered');
        Route::get('/', [RpcppeController::class, 'index'])->name('index');
        Route::get('/create', [RpcppeController::class, 'create'])->name('create');
        Route::post('/', [RpcppeController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RpcppeController::class, 'edit'])->whereNumber('id')->name('edit');
        Route::put('/{id}', [RpcppeController::class, 'update'])->whereNumber('id')->name('update');
        Route::delete('/{id}', [RpcppeController::class, 'destroy'])->whereNumber('id')->name('destroy');

        // ---------- PRINT ----------
        Route::get('/print/table', [RpcppeController::class, 'printTable'])->name('print.table');
        Route::get('/reports/appendix73', [RpcppeController::class, 'appendix73'])->name('reports.appendix73');

        // ---------- EXPORT ----------
        Route::get('/reports/appendix73/export', [RpcppeController::class, 'appendix73Export'])->name('reports.appendix73.export');
        Route::get('/export/excel', [RpcppeController::class, 'exportExcel'])->name('export.excel');
    });
});

require __DIR__ . '/auth.php';
