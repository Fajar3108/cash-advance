<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashAdvanceController;
use App\Http\Controllers\CaUsageController;
use App\Http\Controllers\CaUsageItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::patch('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [AuthController::class, 'changePasswordView'])->name('change-password');
    Route::patch('/change-password', [AuthController::class, 'changePassword'])->name('change-password.update');

    Route::get('/', function () {
        return redirect()->route('cash-advances.index');
    })->name('dashboard');
    Route::resource('cash-advances', CashAdvanceController::class);
    Route::resource('cash-advances/{cashAdvance}/items', ItemController::class)->except('show');
    Route::get('/cash-advances/{cashAdvance}/pdf', [CashAdvanceController::class, 'pdf'])->name('cash-advances.pdf');
    Route::patch('/cash-advances/{cashAdvance}/note', [CashAdvanceController::class, 'note'])->name('cash-advances.note');

    Route::resource('cash-advance/{cashAdvance}/attachments', AttachmentController::class)->only('index', 'store');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');

    Route::resource('ca-usages', CaUsageController::class);
    Route::resource('ca-usages/{caUsage}/ca-usage-items', CaUsageItemController::class)->except('show');
    Route::get('/ca-usages/{caUsage}/pdf', [CaUsageController::class, 'pdf'])->name('ca-usages.pdf');
    Route::patch('/ca-usages/{caUsage}/note', [CaUsageController::class, 'note'])->name('ca-usages.note');

    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::patch('/cash-advances/{cashAdvance}/approve', [CashAdvanceController::class, 'approve'])->name('cash-advances.approve');
        Route::patch('/ca-usages/{caUsage}/approve', [CaUsageController::class, 'approve'])->name('ca-usages.approve');
    });
});
