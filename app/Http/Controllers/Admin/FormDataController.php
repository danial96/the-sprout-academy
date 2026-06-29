<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceWorkOrder;
use App\Models\Suggestion;
use App\Models\TimeClockChangeRequest;
use App\Models\StandardTShirtOrder;
use App\Models\SpecialtyTShirtOrder;
use App\Models\SnackOrder;
use App\Models\TimeOffRequestForm;
use App\Models\SupplyOrder;
use App\Models\NewsletterSubscription;
use App\Models\ChildAbsentForm;
use App\Models\EmploymentApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FormDataController extends Controller
{
    // Maintenance Work Orders
    public function maintenanceWorkOrders(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $orders = MaintenanceWorkOrder::select('*');

            return DataTables::of($orders)
                ->addColumn('full_name', function ($order) {
                    return $order->first_name . ' ' . $order->last_name;
                })
                ->editColumn('todays_date', function ($order) {
                    return $order->todays_date ? $order->todays_date->format('M d, Y') : '';
                })
                ->editColumn('completion_date', function ($order) {
                    return $order->completion_date ? $order->completion_date->format('M d, Y') : '';
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.maintenance-work-orders');
    }

    // Suggestions
    public function suggestions(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $suggestions = Suggestion::select('*');

            return DataTables::of($suggestions)
                ->addColumn('full_name', function ($suggestion) {
                    return $suggestion->first_name . ' ' . $suggestion->last_name;
                })
                ->editColumn('created_at', function ($suggestion) {
                    return $suggestion->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.suggestions');
    }

    // Time Clock Change Requests
    public function timeClockChangeRequests(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $requests = TimeClockChangeRequest::select('*');

            return DataTables::of($requests)
                ->addColumn('full_name', function ($request) {
                    return $request->first_name . ' ' . $request->last_name;
                })
                // ->addColumn('supervisor_name', function ($request) { // TEMPORARILY REMOVED
                //     return $request->supervisor_first_name . ' ' . $request->supervisor_last_name;
                // })
                ->editColumn('date_to_be_changed', function ($request) {
                    return $request->date_to_be_changed ? $request->date_to_be_changed->format('M d, Y') : '';
                })
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.time-clock-change-requests');
    }

    // Time Off Requests
    public function timeOffRequests(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $requests = TimeOffRequestForm::select('*');

            return DataTables::of($requests)
                ->addColumn('full_name', function ($request) {
                    return $request->name;
                })
                ->editColumn('todays_date', function ($request) {
                    return $request->todays_date ? $request->todays_date->format('M d, Y') : '';
                })
                ->editColumn('start_date', function ($request) {
                    return $request->start_date ? $request->start_date->format('M d, Y') : '';
                })
                ->editColumn('end_date', function ($request) {
                    return $request->end_date ? $request->end_date->format('M d, Y') : '';
                })
                ->editColumn('status', function ($request) {
                    $badgeClass = 'warning';
                    if ($request->status === 'approved') {
                        $badgeClass = 'success';
                    } elseif ($request->status === 'rejected') {
                        $badgeClass = 'danger';
                    }
                    return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($request->status) . '</span>';
                })
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('M d, Y h:i A');
                })
                ->addColumn('action', function ($timeOffRequest) {
                    $html = '<div class="btn-group" role="group">';
                    if ($timeOffRequest->status === 'pending') {
                        $html .= '<button type="button" class="btn btn-sm btn-success approve-btn" data-id="' . $timeOffRequest->id . '" title="Approve">
                            <i class="fas fa-check"></i>
                        </button>';
                        $html .= '<button type="button" class="btn btn-sm btn-danger reject-btn" data-id="' . $timeOffRequest->id . '" title="Reject">
                            <i class="fas fa-times"></i>
                        </button>';
                    } else {
                        $html .= '<span class="text-muted">' . ucfirst($timeOffRequest->status) . '</span>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.pages.forms.time-off-requests');
    }

    // Approve Time Off Request
    public function approveTimeOffRequest(Request $request, $id)
    {
        try {
            $timeOffRequest = TimeOffRequestForm::findOrFail($id);

            if ($timeOffRequest->status !== 'pending') {
                return response()->json(['message' => 'Request is not pending.'], 400);
            }

            $timeOffRequest->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            return response()->json(['message' => 'Time off request approved successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error approving request: ' . $e->getMessage()], 500);
        }
    }

    // Reject Time Off Request
    public function rejectTimeOffRequest(Request $request, $id)
    {
        try {
            $timeOffRequest = TimeOffRequestForm::findOrFail($id);

            if ($timeOffRequest->status !== 'pending') {
                return response()->json(['message' => 'Request is not pending.'], 400);
            }

            $timeOffRequest->update([
                'status' => 'rejected',
                'rejected_by' => Auth::id(),
                'rejected_at' => now(),
                'rejection_reason' => $request->input('rejection_reason'),
            ]);

            return response()->json(['message' => 'Time off request rejected successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error rejecting request: ' . $e->getMessage()], 500);
        }
    }

    // Standard T-Shirt Orders
    public function standardTShirtOrders(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $orders = StandardTShirtOrder::select('*');

            return DataTables::of($orders)
                ->addColumn('full_name', function ($order) {
                    return $order->first_name . ' ' . $order->last_name;
                })
                ->editColumn('colors', function ($order) {
                    if (is_array($order->colors)) {
                        return implode(', ', $order->colors);
                    }
                    return $order->colors ?? '';
                })
                ->editColumn('special_instructions', function ($order) {
                    return $order->special_instructions ?? '-';
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.standard-t-shirt-orders');
    }

    // Specialty T-Shirt Orders
    public function specialtyTShirtOrders(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $orders = SpecialtyTShirtOrder::select('*');

            return DataTables::of($orders)
                ->addColumn('full_name', function ($order) {
                    return $order->first_name . ' ' . $order->last_name;
                })
                ->editColumn('themes', function ($order) {
                    if (is_array($order->themes)) {
                        return implode(', ', $order->themes);
                    }
                    return $order->themes ?? '';
                })
                ->editColumn('special_instructions', function ($order) {
                    return $order->special_instructions ?? '-';
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.specialty-t-shirt-orders');
    }

    // Supply Orders
    public function supplyOrders(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $orders = SupplyOrder::select('*');

            return DataTables::of($orders)
                ->addColumn('items_count', function ($order) {
                    if (is_array($order->order_items)) {
                        return count($order->order_items);
                    }
                    return 0;
                })
                ->editColumn('order_items', function ($order) {
                    if (is_array($order->order_items)) {
                        $items = [];
                        foreach ($order->order_items as $key => $value) {
                            if ($value > 0) {
                                $items[] = ucfirst(str_replace('_', ' ', $key)) . ': ' . $value;
                            }
                        }
                        return implode(', ', $items);
                    }
                    return '';
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.supply-orders');
    }

    // Snack Orders
    public function snackOrders(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $orders = SnackOrder::select('*');

            return DataTables::of($orders)
                ->addColumn('items_count', function ($order) {
                    if (is_array($order->order_items)) {
                        return count($order->order_items);
                    }
                    return 0;
                })
                ->editColumn('order_items', function ($order) {
                    if (is_array($order->order_items)) {
                        $items = [];
                        foreach ($order->order_items as $key => $value) {
                            if ($value > 0) {
                                $items[] = ucfirst(str_replace('_', ' ', $key)) . ': ' . $value;
                            }
                        }
                        return implode(', ', $items);
                    }
                    return '';
                })
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.snack-orders');
    }

    // Newsletter Subscriptions
    public function newsletterSubscriptions(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $subscriptions = NewsletterSubscription::select('*');

            return DataTables::of($subscriptions)
                ->editColumn('name', function ($subscription) {
                    return $subscription->name ?? '-';
                })
                ->editColumn('created_at', function ($subscription) {
                    return $subscription->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.newsletter-subscriptions');
    }

    // Child Absent Forms
    public function childAbsentForms(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $forms = ChildAbsentForm::select('*');

            return DataTables::of($forms)
                ->addColumn('full_name', function ($form) {
                    return $form->first_name . ' ' . $form->last_name;
                })
                ->addColumn('child_full_name', function ($form) {
                    return ($form->child_first_name ?? '') . ' ' . ($form->child_last_name ?? '');
                })
                ->editColumn('date_submission', function ($form) {
                    return $form->date_submission ? $form->date_submission->format('M d, Y') : '';
                })
                ->editColumn('date_of_expected_return', function ($form) {
                    return $form->date_of_expected_return ? $form->date_of_expected_return->format('M d, Y') : '';
                })
                ->editColumn('location', function ($form) {
                    return ucfirst(str_replace('-', ' ', $form->location));
                })
                ->editColumn('created_at', function ($form) {
                    return $form->created_at->format('M d, Y h:i A');
                })
                ->make(true);
        }

        return view('backend.pages.forms.child-absent-forms');
    }

    // Employment Applications
    public function employmentApplications(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $applications = EmploymentApplication::select('*');

            return DataTables::of($applications)
                ->addColumn('full_name', function ($application) {
                    return $application->first_name . ' ' . $application->last_name;
                })
                ->editColumn('position', function ($application) {
                    return ucfirst(str_replace('_', ' ', $application->position));
                })
                ->editColumn('location', function ($application) {
                    return ucfirst(str_replace('_', ' ', $application->location));
                })
                ->editColumn('start_date', function ($application) {
                    return $application->start_date ? $application->start_date->format('M d, Y') : '-';
                })
                ->addColumn('salary', function ($application) {
                    $dollars = $application->salary_dollars ?? '0';
                    $cents = $application->salary_cents ?? '00';
                    return '$' . $dollars . '.' . $cents;
                })
                ->addColumn('resume_link', function ($application) {
                    if ($application->resume_path) {
                        $url = asset('storage/' . $application->resume_path);
                        return '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Download</a>';
                    }
                    return '-';
                })
                ->editColumn('created_at', function ($application) {
                    return $application->created_at->format('M d, Y h:i A');
                })
                ->rawColumns(['resume_link'])
                ->make(true);
        }

        return view('backend.pages.forms.employment-applications');
    }
}
