<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

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
        Route::get('/create', [AppointmentController::class, 'create'])->name('create');
        Route::post('/', [AppointmentController::class, 'store'])->name('store');
        Route::get('/', [AppointmentController::class, 'viewAppointment'])->name('viewAppointment');
    });

    // Add these routes inside the authenticated middleware group
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Add these new routes
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])
        ->name('client.appointments.update');
    
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('client.appointments.cancel');
    
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->name('client.appointments.destroy');
});

require __DIR__.'/auth.php';