<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentApprovalController;
use App\Http\Controllers\DocumentController;
Use App\Http\Controllers\GeneralNotificationController;
Use App\Http\Controllers\DashboardController;

Route::get('/',[DashboardController::class, 'index'])
->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::resource('documents', DocumentController::class);
    Route::get('notifications/{id}', [GeneralNotificationController::class,'markAsRead'])->name('notifications.read');
    Route::prefix('documents/{document}')->group(function () {
        Route::get('edit',[DocumentApprovalController::class,'edit'])->name('documents.edit');
        Route::get('show',[DocumentApprovalController::class,'show'])->name('documents.show');
        Route::post('submit', [DocumentApprovalController::class, 'submit'])->name('documents.submit');
        Route::post('approve-admin', [DocumentApprovalController::class, 'approveAdmin'])->name('documents.approve-admin');
        Route::post('approve-hq', [DocumentApprovalController::class, 'approveHq'])->name('documents.approve-hq');
        Route::post('rejected', [DocumentApprovalController::class, 'rejected'])->name('documents.rejected');
        Route::get('copy', [DocumentApprovalController::class, 'copy'])->name('documents.copy');
        Route::post('store', [DocumentApprovalController::class,'store'])->name('documents.store');
        Route::get('/create', [TaskController::class,'create'])->name('task.create');
        Route::get('/index', [TaskController::class,'index'])->name('task.index');
    });
        
    Route::post('/store', [TaskController::class,'store'])->name('task.store');
    
    
    Route::prefix('task/{task}')->group(function () {
        Route::post('/update', [TaskController::class,'update'])->name('task.update');
        Route::get('/show', [TaskController::class,'show'])->name('task.show');
        Route::get('/edit', [TaskController::class,'edit'])->name('task.edit');
        
        Route::get('/', [TaskController::class, 'index'])->name('task.index');
        Route::post('/destroy', [TaskController::class, 'destroy'])->name('task.destroy');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
