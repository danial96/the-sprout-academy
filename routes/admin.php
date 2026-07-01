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
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Form Data Routes (Optimized - Single route for view and data)
    Route::controller(FormDataController::class)->prefix('forms')->name('forms.')->group(function () {
        Route::any('/maintenance-work-orders', 'maintenanceWorkOrders')->name('maintenance-work-orders');
        Route::get('/maintenance-work-orders/{id}', 'maintenanceWorkOrderShow')->name('maintenance-work-orders.show');
        Route::delete('/maintenance-work-orders/{id}', 'deleteMaintenanceWorkOrder')->name('maintenance-work-orders.delete');
        Route::any('/suggestions', 'suggestions')->name('suggestions');
        Route::delete('/suggestions/{id}', 'deleteSuggestion')->name('suggestions.delete');
        Route::any('/time-clock-change-requests', 'timeClockChangeRequests')->name('time-clock-change-requests');
        Route::delete('/time-clock-change-requests/{id}', 'deleteTimeClockChangeRequest')->name('time-clock-change-requests.delete');
        Route::any('/time-off-requests', 'timeOffRequests')->name('time-off-requests');
        Route::post('/time-off-requests/{id}/approve', 'approveTimeOffRequest')->name('time-off-requests.approve');
        Route::post('/time-off-requests/{id}/reject', 'rejectTimeOffRequest')->name('time-off-requests.reject');
        Route::delete('/time-off-requests/{id}', 'deleteTimeOffRequest')->name('time-off-requests.delete');
        Route::any('/standard-t-shirt-orders', 'standardTShirtOrders')->name('standard-t-shirt-orders');
        Route::delete('/standard-t-shirt-orders/{id}', 'deleteStandardTShirtOrder')->name('standard-t-shirt-orders.delete');
        Route::any('/specialty-t-shirt-orders', 'specialtyTShirtOrders')->name('specialty-t-shirt-orders');
        Route::delete('/specialty-t-shirt-orders/{id}', 'deleteSpecialtyTShirtOrder')->name('specialty-t-shirt-orders.delete');
        Route::any('/supply-orders', 'supplyOrders')->name('supply-orders');
        Route::delete('/supply-orders/{id}', 'deleteSupplyOrder')->name('supply-orders.delete');
        Route::any('/snack-orders', 'snackOrders')->name('snack-orders');
        Route::delete('/snack-orders/{id}', 'deleteSnackOrder')->name('snack-orders.delete');
        Route::any('/newsletter-subscriptions', 'newsletterSubscriptions')->name('newsletter-subscriptions');
        Route::delete('/newsletter-subscriptions/{id}', 'deleteNewsletterSubscription')->name('newsletter-subscriptions.delete');
        Route::any('/child-absent-forms', 'childAbsentForms')->name('child-absent-forms');
        Route::delete('/child-absent-forms/{id}', 'deleteChildAbsentForm')->name('child-absent-forms.delete');
        Route::any('/employment-applications', 'employmentApplications')->name('employment-applications');
        Route::delete('/employment-applications/{id}', 'deleteEmploymentApplication')->name('employment-applications.delete');
    });

    // User Management - Admin can create employee users
    Route::controller(UserManagementController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::patch('/{id}/toggle-restrict', 'toggleRestrict')->name('toggle-restrict');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    // Locations Management
    Route::resource('locations', LocationController::class);
    Route::patch('locations/{id}/toggle-active', [LocationController::class, 'toggleActive'])->name('locations.toggle-active');
});
