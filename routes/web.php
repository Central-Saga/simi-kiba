<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Pengguna
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::patch('users/{user}/toggle', [\App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle');
        
        // Roles & Permissions
        Route::get('/roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [\App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}', [\App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
        
        // Lokasi
        Route::resource('locations', \App\Http\Controllers\LocationController::class);

        // Aset
        Route::resource('assets', \App\Http\Controllers\AssetController::class);

        // Penggunaan Aset
        Route::get('/usages', [\App\Http\Controllers\AssetUsageController::class, 'index'])->name('usages.index');
        Route::get('/usages/create', [\App\Http\Controllers\AssetUsageController::class, 'create'])->name('usages.create');
        Route::post('/usages', [\App\Http\Controllers\AssetUsageController::class, 'store'])->name('usages.store');

        // Mutasi Aset
        Route::get('/mutations', [\App\Http\Controllers\AssetMutationController::class, 'index'])->name('mutations.index');
        Route::get('/mutations/create', [\App\Http\Controllers\AssetMutationController::class, 'create'])->name('mutations.create');
        Route::post('/mutations', [\App\Http\Controllers\AssetMutationController::class, 'store'])->name('mutations.store');

        // Permintaan Stok
        Route::get('/requests', [\App\Http\Controllers\StockRequestController::class, 'index'])->name('requests.index');
        Route::patch('/requests/{stockRequest}/approve', [\App\Http\Controllers\StockRequestController::class, 'approve'])->name('requests.approve');
        Route::patch('/requests/{stockRequest}/reject', [\App\Http\Controllers\StockRequestController::class, 'reject'])->name('requests.reject');
        
        // Laporan
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [\App\Http\Controllers\ReportController::class, 'print'])->name('reports.print');

        // Log Aktivitas
        Route::get('/logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('logs.index');
        
        // Future admin routes here
    });

    // Staff Routes
    Route::middleware(['role:staf'])->prefix('staf')->name('staf.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Aset (Read only)
        Route::get('/assets', [\App\Http\Controllers\AssetController::class, 'index'])->name('assets.index');
        Route::get('/assets/{asset}', [\App\Http\Controllers\AssetController::class, 'show'])->name('assets.show');

        // Penggunaan Aset
        Route::get('/usages', [\App\Http\Controllers\AssetUsageController::class, 'index'])->name('usages.index');
        Route::get('/usages/create', [\App\Http\Controllers\AssetUsageController::class, 'create'])->name('usages.create');
        Route::post('/usages', [\App\Http\Controllers\AssetUsageController::class, 'store'])->name('usages.store');

        // Permintaan Stok
        Route::get('/requests', [\App\Http\Controllers\StockRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/create', [\App\Http\Controllers\StockRequestController::class, 'create'])->name('requests.create');
        Route::post('/requests', [\App\Http\Controllers\StockRequestController::class, 'store'])->name('requests.store');

        // Future staff routes here
    });
});

require __DIR__.'/settings.php';
