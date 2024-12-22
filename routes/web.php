<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InternalAppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExternalAppointmentController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard'); // This will then redirect to the appropriate dashboard based on role
    }
    return view('auth.login');
});

// Protected routes that require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('admin.dashboard');

    // Dashboard redirect based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect()->route('client.appointments.create');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Appointment routes
    Route::prefix('appointments')->name('client.appointments.')->group(function () {
        Route::get('/create', [InternalAppointmentController::class, 'create'])->name('create');
        Route::post('/', [InternalAppointmentController::class, 'store'])->name('store');
        Route::get('/', [InternalAppointmentController::class, 'viewAppointment'])->name('viewAppointment');
        Route::put('/{appointment}', [InternalAppointmentController::class, 'update'])->name('update');
        Route::patch('/{appointment}/cancel', [InternalAppointmentController::class, 'cancel'])->name('cancel');
        Route::delete('/{appointment}', [InternalAppointmentController::class, 'destroy'])->name('destroy');
    });

    // Add these routes inside the authenticated middleware group
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/appointments', [ExternalAppointmentController::class, 'index'])->name('appointments.index');
        Route::post('/appointments/store', [ExternalAppointmentController::class, 'store'])->name('appointments.store');
    });
});

require __DIR__.'/auth.php';