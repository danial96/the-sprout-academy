<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EmployeeRegisterController;




// TEMPORARY - Patch FormController resume field
Route::get('/patch-resume-k9x2m', function () {
    $file = app_path('Http/Controllers/FormController.php');
    $contents = file_get_contents($file);
    $old = "'resume' => \$resumePath ? 'Resume Attached' : 'Resume Not Attached'";
    $old2 = "'resume' => \$resumePath ? 'File attached (see admin panel for download)' : 'No Resume Attached'";
    $new = "'resume' => \$resumePath ? url('/admin/forms/employment-applications/' . \$application->id . '/resume?action=download') : 'No Resume Attached'";
    $updated = str_replace([$old, $old2], $new, $contents);
    if ($updated === $contents) return 'No change needed OR already patched — search manually.';
    file_put_contents($file, $updated);
    return 'Patched successfully!';
});

// TEMPORARY - Clear SproutVine news cache
Route::get('/clear-news-cache-k7m3x', function () {
    \Illuminate\Support\Facades\Cache::forget('sproutvine_news');
    return 'SproutVine news cache cleared. Refresh home page to see updated images.';
});

// TEMPORARY MIGRATION ROUTE - DELETE AFTER USE
Route::get('/run-migration-xk92p', function () {
    try {
        \Illuminate\Support\Facades\Schema::table('users', function (\Illuminate\Database\Schema\Blueprint $table) {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'is_restricted')) {
                $table->boolean('is_restricted')->default(false)->after('role');
            }
        });
        return 'Migration done: is_restricted column added to users table.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// TEMPORARY - Create otp_verifications table
Route::get('/run-otp-migration-k7m3x', function () {
    try {
        if (!\Illuminate\Support\Facades\Schema::hasTable('otp_verifications')) {
            \Illuminate\Support\Facades\Schema::create('otp_verifications', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->string('email');
                $table->string('otp', 6);
                $table->timestamp('expires_at');
                $table->boolean('used')->default(false);
                $table->timestamps();
                $table->index('email');
            });
            return 'Done: otp_verifications table created.';
        }
        return 'Table already exists.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// TEMPORARY - View latest OTP for testing (remove after confirming mail works)
Route::get('/debug-otp-k7m3x/{email}', function ($email) {
    $otp = \App\Models\OtpVerification::where('email', strtolower($email))
        ->where('used', false)
        ->where('expires_at', '>', now())
        ->latest()
        ->first();
    if (!$otp) return 'No active OTP found for ' . $email . '. Try signing up first.';
    return 'OTP for ' . $email . ': <strong style="font-size:24px;color:green">' . $otp->otp . '</strong> (expires: ' . $otp->expires_at . ')';
});

Route::controller(FrontendController::class)->name('frontend.')->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/virtual-tour', 'VirtualTour')->name('virtualTour');
    Route::get('/the-sprout-academy-difference', 'TheSproutAcademyDifference')->name('theSproutAcademyDifference');
    Route::get('/we-care-for-your-child', 'WeCareForYourChild')->name('weCareForYourChild');
    Route::get('/tuition-costs', 'TuitionCosts')->name('tuitionCosts');
    Route::get('/meet-the-team', 'MeetTheTeam')->name('meetTheTeam');
    Route::get('/meet-the-owner', 'MeetTheOwner')->name('meetTheOwner');
    Route::get('/download-forms', 'DownloadForms')->name('downloadForms');
    Route::get('/parents-forms', 'ParentsForms')->name('parentsForms');
    Route::get('/locations', 'Locations')->name('locations');
    Route::get('/location/seminole', 'LocationSeminole')->name('locationSeminole');
    Route::get('/location/clearwater', 'LocationClearwater')->name('locationClearwater');
    Route::get('/location/st-petersburg', 'LocationStPetersburg')->name('locationStPetersburg');
    Route::get('/location/pinellas-park', 'LocationPinellasPark')->name('locationPinellasPark');
    Route::get('/location/montessori', 'LocationMontessori')->name('locationMontessori');
    Route::get('/location/largo', 'LocationLargo')->name('locationLargo');
    Route::get('/our-programs', 'OurPrograms')->name('ourPrograms');
    Route::get('our-programs/infant-toddler-education', 'InfantToddlerEducation')->name('infantToddlerEducation');
    Route::get('our-programs/preschool-early-education', 'PreschoolEarlyEducation')->name('preschoolEarlyEducation');
    Route::get('our-programs/education-for-5-12-year-old', 'EducationFor512YearOld')->name('educationFor512YearOld');
    Route::get('/for-parents', 'Parents')->name('parents');
    Route::get('/sproutvine', 'Sproutvine')->name('sproutvine');
    Route::get('/thank-you', 'ThankYou')->name('thankYou');
    Route::get('/enroll', 'Enroll')->name('enroll');
    Route::post('/enroll/contact-message', 'submitEnrollContactMessage')->name('enroll.contactMessage');
    Route::any('/child-absent-form', 'ChildAbsentForm')->name('childAbsentForm');
    Route::get('/corporate-responsibility', 'CorporateResponsibility')->name('corporateResponsibility');
    Route::get('/non-discrimination-policy', 'NonDiscriminationPolicy')->name('nonDiscriminationPolicy');
});

// Employee Forms (Public - No Authentication Required)
Route::get('/employee-forms', [FrontendController::class, 'EmployeeForms'])->name('frontend.employeeForms');
Route::get('/employee-login', [FrontendController::class, 'EmployeeLoginForm'])->middleware('guest')->name('frontend.employeeLogin');

// Employee Self-Registration (OTP flow)
Route::middleware('guest')->group(function () {
    Route::get('/employee-signup', [EmployeeRegisterController::class, 'showEmailForm'])->name('employee.signup');
    Route::post('/employee-signup/send-otp', [EmployeeRegisterController::class, 'sendOtp'])->name('employee.signup.send-otp');
    Route::get('/employee-signup/verify', [EmployeeRegisterController::class, 'showVerifyForm'])->name('employee.signup.verify');
    Route::post('/employee-signup/verify', [EmployeeRegisterController::class, 'verifyOtp'])->name('employee.signup.verify');
    Route::post('/employee-signup/resend', [EmployeeRegisterController::class, 'resendOtp'])->name('employee.signup.resend');
    Route::get('/employee-signup/register', [EmployeeRegisterController::class, 'showRegisterForm'])->name('employee.signup.register');
    Route::post('/employee-signup/register', [EmployeeRegisterController::class, 'register'])->name('employee.signup.register');
});


// Form Routes (Public - No Authentication Required)
// All forms can be submitted without login. Authentication is optional.
Route::controller(FormController::class)->name('form.')->group(function () {
    Route::any('/time-off-request-form', 'TimeOffRequestForm')->name('timeOffRequestForm');
    Route::any('/maintenance-work-order-form', 'maintenanceWorkOrder')->name('maintenanceWorkOrder');
    Route::any('/supply-order-form', 'supplyOrder')->name('supplyOrder');
    Route::any('/snack-order-form', 'snackOrder')->name('snackOrder');
    Route::any('/suggestion-form', 'suggestion')->name('suggestion');
    Route::any('/time-clock-change-request-form', 'timeClockChangeRequest')->name('timeClockChangeRequest');
    Route::any('/standard-t-shirt-order-form', 'standardTShirtOrder')->name('standardTShirtOrder');
    Route::any('/specialty-t-shirt-order-form', 'specialtyTShirtOrder')->name('specialtyTShirtOrder');
    Route::any('/employment-application-form', 'employmentApplication')->name('employmentApplication');
    Route::post('/newsletter-subscribe', 'subscribeNewsletter')->name('subscribeNewsletter');
    Route::get('/api/time-off-requests/calendar', 'getTimeOffRequestsForCalendar')->name('timeOffRequests.calendar');
});

// Auth Routes (Breeze)
require __DIR__ . '/auth.php';

// Dashboard Redirect (for backward compatibility)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()?->role === 'employee'
            ? redirect()->route('frontend.employeeForms')
            : redirect()->route('admin.dashboard');
    })->name('dashboard');
});

// Profile Routes (Authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Enrollment Routes (Public - No Authentication Required)
// Enrollment forms can be submitted without login. Authentication is optional.
Route::controller(EnrollmentController::class)->prefix('enrollment')->name('enrollment.')->group(function () {
    Route::get('/{location}', 'showLocationEnrollmentForm')->name('start'); // Initial email form
    Route::post('/{location}', 'startEnrollment')->name('start.post'); // Submit email (POST to same URL)
    Route::get('/{location}/form', 'showEnrollmentForm')->name('form'); // Step 1 enrollment form
    Route::post('/{location}/step1', 'saveStep1')->name('saveStep1');
    Route::get('/{location}/step2', 'showStep2')->name('step2');
    Route::post('/{location}/step2', 'saveStep2')->name('saveStep2');
    Route::get('/{location}/step3', 'showStep3')->name('step3');
    Route::post('/{location}/step3', 'saveStep3')->name('saveStep3');
    Route::get('/{location}/step4', 'showStep4')->name('step4');
    Route::post('/{location}/submit', 'submitEnrollment')->name('submit');
    Route::get('/{location}/thank-you', 'thankYou')->name('thankYou');
});

