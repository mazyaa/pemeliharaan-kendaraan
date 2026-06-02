<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\Pengelola\PengajuanController;
use App\Http\Controllers\Kabag\ApprovalController;
use App\Http\Controllers\Kabiro\DisposisiController;
use App\Http\Controllers\Pptk\PptkApprovalController;
use App\Http\Controllers\Pptk\SpkController;
use App\Http\Controllers\Pptk\RiwayatController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('roles', RoleController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('kendaraan', KendaraanController::class)->only(['index', 'store', 'update', 'destroy']);
    });

    // Laporan Routes (admin only, no admin. name prefix)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    });

    // Pengelola Kendaraan Routes
    Route::prefix('pengelola')->name('pengelola.')->middleware('role:pengelola_kendaraan')->group(function () {
        Route::resource('pengajuan', PengajuanController::class);
        Route::post('pengajuan/{id}/submit', [PengajuanController::class, 'submit'])->name('pengajuan.submit');
    });

    // Kepala Bagian Routes
    Route::prefix('kabag')->name('kabag.')->middleware('role:kepala_bagian')->group(function () {
        Route::get('approval', [ApprovalController::class, 'index'])->name('approval.index');
        Route::get('approval/history', [ApprovalController::class, 'history'])->name('approval.history');
        Route::get('approval/{id}', [ApprovalController::class, 'show'])->name('approval.show');
        Route::post('approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('approval/{id}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    });

    // Kepala Biro Routes
    Route::prefix('kabiro')->name('kabiro.')->middleware('role:kepala_biro')->group(function () {
        Route::get('disposisi', [DisposisiController::class, 'index'])->name('disposisi.index');
        Route::get('disposisi/history', [DisposisiController::class, 'history'])->name('disposisi.history');
        Route::get('disposisi/{id}', [DisposisiController::class, 'show'])->name('disposisi.show');
        Route::post('disposisi/{id}/approve', [DisposisiController::class, 'approve'])->name('disposisi.approve');
        Route::post('disposisi/{id}/reject', [DisposisiController::class, 'reject'])->name('disposisi.reject');
    });

    // PPTK Routes
    Route::prefix('pptk')->name('pptk.')->middleware('role:pptk')->group(function () {
        Route::get('approval', [PptkApprovalController::class, 'index'])->name('approval.index');
        Route::get('approval/history', [PptkApprovalController::class, 'history'])->name('approval.history');
        Route::get('approval/{id}', [PptkApprovalController::class, 'show'])->name('approval.show');
        Route::post('approval/{id}/approve', [PptkApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('approval/{id}/reject', [PptkApprovalController::class, 'reject'])->name('approval.reject');
        Route::post('approval/{id}/generate-spk', [PptkApprovalController::class, 'generateSpk'])->name('approval.generateSpk');

        Route::resource('spk', SpkController::class)->only(['index', 'show']);
        Route::get('spk/{id}/preview', [SpkController::class, 'preview'])->name('spk.preview');
        Route::get('spk/{id}/download', [SpkController::class, 'download'])->name('spk.download');

        Route::resource('riwayat', RiwayatController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    });

    // Laporan Routes moved to admin group
});

require __DIR__.'/auth.php';