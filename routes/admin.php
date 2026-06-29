<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\FormDataController;
use App\Http\Controllers\Admin\AdminEnrollmentController;
use App\Http\Controllers\Admin\LocationController;

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Enrollment Routes
    Route::controller(AdminEnrollmentController::class)->prefix('enrollments')->name('enrollments.')->group(function () {
        Route::any('/', 'index')->name('index');
        Route::get('/locations', 'getLocations')->name('locations');
        Route::get('/{id}', 'show')->name('show');
    });

    // Form Data Routes (Optimized - Single route for view and data)
    Route::controller(FormDataController::class)->prefix('forms')->name('forms.')->group(function () {
        Route::any('/maintenance-work-orders', 'maintenanceWorkOrders')->name('maintenance-work-orders');
        Route::any('/suggestions', 'suggestions')->name('suggestions');
        Route::any('/time-clock-change-requests', 'timeClockChangeRequests')->name('time-clock-change-requests');
        Route::any('/time-off-requests', 'timeOffRequests')->name('time-off-requests');
        Route::post('/time-off-requests/{id}/approve', 'approveTimeOffRequest')->name('time-off-requests.approve');
        Route::post('/time-off-requests/{id}/reject', 'rejectTimeOffRequest')->name('time-off-requests.reject');
        Route::any('/standard-t-shirt-orders', 'standardTShirtOrders')->name('standard-t-shirt-orders');
        Route::any('/specialty-t-shirt-orders', 'specialtyTShirtOrders')->name('specialty-t-shirt-orders');
        Route::any('/supply-orders', 'supplyOrders')->name('supply-orders');
        Route::any('/snack-orders', 'snackOrders')->name('snack-orders');
        Route::any('/newsletter-subscriptions', 'newsletterSubscriptions')->name('newsletter-subscriptions');
        Route::any('/child-absent-forms', 'childAbsentForms')->name('child-absent-forms');
        Route::any('/employment-applications', 'employmentApplications')->name('employment-applications');
    });

    // User Management - Admin can create employee users
    Route::controller(UserManagementController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
    });

    // Locations Management
    Route::resource('locations', LocationController::class);
});
