<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InternalAppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExternalAppointmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ClientReportController;
use App\Http\Controllers\AdminReportController;

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

    // Move this route OUTSIDE the admin prefix group but keep it inside auth middleware
    Route::get('admin/appointments/available-times', [ExternalAppointmentController::class, 'getAvailableTimes'])
        ->name('admin.appointments.available-times');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/appointments', [ExternalAppointmentController::class, 'index'])->name('admin.appointments.index');
        Route::post('/appointments/store', [ExternalAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/{id}', [ExternalAppointmentController::class, 'show'])->name('admin.appointments.show');
        Route::patch('/appointments/{appointment}/confirm', [ExternalAppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::patch('/appointments/{appointment}/cancel', [ExternalAppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::patch('/appointments/{appointment}/complete', [ExternalAppointmentController::class, 'complete'])->name('appointments.complete');
        Route::delete('/appointments/{appointment}', [ExternalAppointmentController::class, 'destroy'])->name('appointments.destroy');
        Route::put('/appointments/{appointment}/update', [ExternalAppointmentController::class, 'update'])
            ->name('appointments.update');
    });

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');

    // Add this route for internal appointments
    Route::get('/client/appointments/available-times', [InternalAppointmentController::class, 'getAvailableTimes'])
        ->name('client.appointments.available-times');

    // Client routes
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('appointments/available-times', [InternalAppointmentController::class, 'getAvailableTimes'])
            ->name('appointments.available-times');
        // ... other routes ...
    });

    // Client Report Routes
    Route::controller(ClientReportController::class)->group(function () {
        Route::get('/client/report/generate', 'generate')->name('client.report.generate');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        // ... other admin routes ...
        Route::get('/admin/report/generate', [AdminReportController::class, 'generate'])
            ->name('admin.report.generate');
        Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
        Route::post('/admin/reports/generate', [AdminReportController::class, 'generate'])->name('admin.reports.generate');
    });
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::post('/reports/generate', [AdminReportController::class, 'generate'])->name('admin.reports.generate');
});

require __DIR__.'/auth.php';