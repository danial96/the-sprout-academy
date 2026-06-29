<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceWorkOrder;
use App\Models\Suggestion;
use App\Models\TimeClockChangeRequest;
use App\Models\StandardTShirtOrder;
use App\Models\SpecialtyTShirtOrder;
use App\Models\SnackOrder;
use App\Models\SupplyOrder;
use App\Models\NewsletterSubscription;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'enrollments' => Enrollment::count(),
            'enrollments_submitted' => Enrollment::where('status', 'submitted')->count(),
            'maintenance_work_orders' => MaintenanceWorkOrder::count(),
            'suggestions' => Suggestion::count(),
            'time_clock_change_requests' => TimeClockChangeRequest::count(),
            'standard_t_shirt_orders' => StandardTShirtOrder::count(),
            'specialty_t_shirt_orders' => SpecialtyTShirtOrder::count(),
            'supply_orders' => SupplyOrder::count(),
            'snack_orders' => SnackOrder::count(),
            'newsletter_subscriptions' => NewsletterSubscription::count(),
        ];

        return view('backend.pages.dashboard', compact('stats'));
    }
}
