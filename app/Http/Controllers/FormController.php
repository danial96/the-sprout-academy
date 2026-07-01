<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceWorkOrder;
use App\Models\Suggestion;
use App\Models\TimeOffRequestForm;
use App\Models\TimeClockChangeRequest;
use App\Models\StandardTShirtOrder;
use App\Models\SpecialtyTShirtOrder;
use App\Models\NewsletterSubscription;
use App\Models\SnackOrder;
use App\Models\SupplyOrder;
use App\Models\EmploymentApplication;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Helpers\FormEmailHelper;
use App\Helpers\GraphMailer;
use Carbon\Carbon;

class FormController extends Controller
{
    public function TimeOffRequestForm(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // If user is logged in, name and email are optional (will use user's data)
                $user = auth()->user();
                $validationRules = [
                    'location' => 'required|string|in:seminole,pinellas_park,largo,st_petersburg,montessori',
                    'todays_date' => 'required|date',
                    'start_date' => 'required|date|after_or_equal:todays_date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'paid_unpaid' => 'required|string|in:paid,unpaid',
                    'reason' => 'nullable|string|max:5000',
                    // 'director_signature' => 'nullable|string|max:255', // TEMPORARILY REMOVED
                ];

                if (!$user) {
                    // If not logged in, name and email are required
                    $validationRules['name'] = 'required|string|max:255';
                    $validationRules['email'] = 'required|email|max:255';
                } else {
                    // If logged in, name and email are optional
                    $validationRules['name'] = 'nullable|string|max:255';
                    $validationRules['email'] = 'nullable|email|max:255';
                }

                $validator = Validator::make($request->all(), $validationRules, [
                    'name.required' => 'Name is required.',
                    'email.required' => 'Email is required.',
                    'email.email' => 'Please enter a valid email address.',
                    'location.required' => 'Location is required.',
                    'todays_date.required' => 'Today\'s date is required.',
                    'start_date.required' => 'Start date is required.',
                    'start_date.after_or_equal' => 'Start date must be today or later.',
                    'end_date.required' => 'End date is required.',
                    'end_date.after_or_equal' => 'End date must be on or after start date.',
                    'paid_unpaid.required' => 'Please select paid or unpaid.',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                // Get logged in user if any
                $user = auth()->user();

                // If user is logged in, use their data
                $name = $user ? $user->name : $request->name;
                $email = $user ? $user->email : $request->email;

                // Create time off request with default pending status
                $timeOffRequest = TimeOffRequestForm::create([
                    'user_id' => $user ? $user->id : null,
                    'name' => $name,
                    'email' => $email,
                    'location' => $request->location,
                    'todays_date' => $request->todays_date,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'paid_unpaid' => $request->paid_unpaid,
                    'reason' => $request->reason,
                    // 'director_signature' => $request->director_signature, // TEMPORARILY REMOVED
                    'status' => 'pending', // Default status
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'name' => $name,
                        'email' => $email,
                        'location' => ucwords(str_replace('_', ' ', $request->location)),
                        'todays_date' => $request->todays_date,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'paid_unpaid' => ucfirst($request->paid_unpaid),
                        'reason' => $request->reason,
                        // 'director_signature' => $request->director_signature, // TEMPORARILY REMOVED
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'time_off_request', 'Time Off Request Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send time off request email: ' . $e->getMessage());
                }

                return response()->json(['message' => 'Time off request submitted successfully!'], 200);

            } catch (\Exception $e) {
                Log::error('Error submitting time off request form: ' . $e->getMessage(), [
                    'exception' => $e,
                    'request_data' => $request->all(),
                ]);
                return response()->json(['message' => 'An error occurred while submitting the form.'], 500);
            }
        }

        // Handle GET request - Display form
        return view('frontend.pages.forms.time_off_request_form');
    }

    /**
     * Get time off requests for calendar display
     */
    public function getTimeOffRequestsForCalendar(Request $request)
    {
        $location = $request->get('location');
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // Convert month to integer for comparison
        $monthInt = (int) $month;
        $yearInt = (int) $year;

        // Get all approved requests that overlap with the requested month/year
        // A request overlaps if:
        // 1. It starts in this month/year, OR
        // 2. It ends in this month/year, OR
        // 3. It starts before this month and ends after this month
        $startOfMonth = Carbon::create($yearInt, $monthInt, 1)->startOfDay();
        $endOfMonth = Carbon::create($yearInt, $monthInt, 1)->endOfMonth()->endOfDay();

        // Build query - Show all approved requests regardless of location
        // Location filter removed so all approved requests show on calendar
        $query = TimeOffRequestForm::where('status', 'approved')
            ->where(function ($q) use ($startOfMonth, $endOfMonth) {
                $q->where(function ($subQ) use ($startOfMonth, $endOfMonth) {
                    // Request starts before or on the end of month and ends on or after start of month
                    $subQ->where('start_date', '<=', $endOfMonth)
                        ->where('end_date', '>=', $startOfMonth);
                });
            });

        $results = $query->get()->map(function ($req) {
            return [
                'id' => $req->id,
                'name' => $req->name,
                'location' => $req->location,
                'start_date' => $req->start_date->format('Y-m-d'),
                'end_date' => $req->end_date->format('Y-m-d'),
                'status' => $req->status,
            ];
        });

        return response()->json($results);
    }

    /**
     * Maintenance Work Order Form - Display and Submit
     */
    public function maintenanceWorkOrder(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation rules
                $validator = Validator::make($request->all(), [
                    'todays_date' => 'required|date',
                    'completion_date' => 'required|date|after_or_equal:todays_date',
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'phone_number' => 'required|string|max:20',
                    'email' => 'required|email|max:255',
                    'location' => 'required|string|in:seminole,orlando,tampa',
                    'description' => 'nullable|string|max:5000',
                    'attach_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
                    'area_repair' => 'required|string|in:plumbing,electrical,hvac,painting,carpentry,other',
                ], [
                    'todays_date.required' => 'Today\'s date is required.',
                    'todays_date.date' => 'Today\'s date must be a valid date.',
                    'completion_date.required' => 'Completion date is required.',
                    'completion_date.date' => 'Completion date must be a valid date.',
                    'completion_date.after_or_equal' => 'Completion date must be today or later.',
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'phone_number.required' => 'Phone number is required.',
                    'email.required' => 'Email is required.',
                    'email.email' => 'Please enter a valid email address.',
                    'location.required' => 'Location is required.',
                    'location.in' => 'Please select a valid location.',
                    'attach_file.file' => 'The file must be a valid file.',
                    'attach_file.mimes' => 'The file must be a PDF, DOC, DOCX, JPG, JPEG, or PNG file.',
                    'attach_file.max' => 'The file size must not exceed 10MB.',
                    'area_repair.required' => 'Area repair is required.',
                    'area_repair.in' => 'Please select a valid area of repair.',
                ]);

                // If validation fails, return back with errors
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // Handle file upload
                $filePath = null;
                if ($request->hasFile('attach_file')) {
                    $file = $request->file('attach_file');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('maintenance_work_orders', $fileName, 'public');
                }

                // Create maintenance work order
                $workOrder = MaintenanceWorkOrder::create([
                    'todays_date' => $request->todays_date,
                    'completion_date' => $request->completion_date,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'location' => $request->location,
                    'description' => $request->description,
                    'file_path' => $filePath,
                    'area_repair' => $request->area_repair,
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone_number' => $request->phone_number,
                        'email' => $request->email,
                        'location' => ucwords($request->location),
                        'todays_date' => $request->todays_date,
                        'completion_date' => $request->completion_date,
                        'area_repair' => ucwords($request->area_repair),
                        'description' => $request->description,
                        'attach_file' => $filePath ? 'File attached' : null,
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'maintenance_work_order', 'Maintenance Work Order Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send maintenance work order email: ' . $e->getMessage());
                }

                // Log success
                Log::info('Maintenance work order submitted', [
                    'id' => $workOrder->id,
                    'email' => $workOrder->email,
                    'location' => $workOrder->location,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Your maintenance work order has been submitted successfully!',
                    'data' => [
                        'id' => $workOrder->id,
                    ]
                ], 200);

            } catch (\Exception $e) {
                // Log error
                Log::error('Maintenance work order submission failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting your form. Please try again later.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        // Handle GET request - Show form
        return view('frontend.pages.forms.maintenance_work_order_form');
    }

    /**
     * Suggestion Form - Display and Submit
     */
    public function suggestion(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation rules
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'subject' => 'required|string|max:255',
                    'description' => 'nullable|string|max:5000',
                ], [
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'subject.required' => 'Subject is required.',
                ]);

                // If validation fails, return back with errors
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // Create suggestion
                $suggestion = Suggestion::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'subject' => $request->subject,
                    'description' => $request->description,
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'subject' => $request->subject,
                        'description' => $request->description,
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'suggestion', 'New Suggestion Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send suggestion email: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Your suggestion has been submitted successfully!',
                    'data' => [
                        'id' => $suggestion->id,
                    ]
                ], 200);

            } catch (\Exception $e) {
                // Log error
                Log::error('Suggestion submission failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting your form. Please try again later.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        // Handle GET request - Show form
        return view('frontend.pages.forms.suggestion_form');
    }

    /**
     * Time Clock Change Request Form - Display and Submit
     */
    public function timeClockChangeRequest(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation rules
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'location' => 'required|string|in:seminole,pinellas_park,largo,st_petersburg,montessori',
                    'date_to_be_changed' => 'required|date',
                    'clock_in_time' => 'required|date_format:H:i',
                    'clock_out_for_lunch' => 'nullable|date_format:H:i',
                    'clock_in_from_lunch' => 'nullable|date_format:H:i',
                    'clock_out_time' => 'nullable|date_format:H:i',
                    'reason_for_change' => 'required|string|max:255',
                    // 'supervisor_first_name' => 'required|string|max:255', // TEMPORARILY REMOVED
                    // 'supervisor_last_name' => 'required|string|max:255', // TEMPORARILY REMOVED
                ], [
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'location.required' => 'Center location is required.',
                    'location.in' => 'Please select a valid center location.',
                    'date_to_be_changed.required' => 'Date to be changed is required.',
                    'date_to_be_changed.date' => 'Date to be changed must be a valid date.',
                    'clock_in_time.required' => 'Clock in time is required.',
                    'clock_in_time.date_format' => 'Clock in time must be in valid time format.',
                    'clock_out_for_lunch.date_format' => 'Clock out for lunch must be in valid time format.',
                    'clock_in_from_lunch.date_format' => 'Clock in from lunch must be in valid time format.',
                    'clock_out_time.date_format' => 'Clock out time must be in valid time format.',
                    'reason_for_change.required' => 'Reason for change is required.',
                    // 'supervisor_first_name.required' => 'E-Signature first name is required.', // TEMPORARILY REMOVED
                    // 'supervisor_last_name.required' => 'E-Signature last name is required.', // TEMPORARILY REMOVED
                ]);

                // If validation fails, return JSON response for AJAX
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please correct the errors below.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                // Create time clock change request
                $timeClockChangeRequest = TimeClockChangeRequest::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'location' => $request->location,
                    'date_to_be_changed' => $request->date_to_be_changed,
                    'clock_in_time' => $request->clock_in_time,
                    'clock_out_for_lunch' => $request->clock_out_for_lunch,
                    'clock_in_from_lunch' => $request->clock_in_from_lunch,
                    'clock_out_time' => $request->clock_out_time,
                    'reason_for_change' => $request->reason_for_change,
                    // 'supervisor_first_name' => $request->supervisor_first_name, // TEMPORARILY REMOVED
                    // 'supervisor_last_name' => $request->supervisor_last_name, // TEMPORARILY REMOVED
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'location' => ucwords(str_replace('_', ' ', $request->location)),
                        'date_to_be_changed' => $request->date_to_be_changed,
                        'clock_in_time' => $request->clock_in_time,
                        'clock_out_for_lunch' => $request->clock_out_for_lunch,
                        'clock_in_from_lunch' => $request->clock_in_from_lunch,
                        'clock_out_time' => $request->clock_out_time,
                        'reason_for_change' => $request->reason_for_change,
                        // 'supervisor_first_name' => $request->supervisor_first_name, // TEMPORARILY REMOVED
                        // 'supervisor_last_name' => $request->supervisor_last_name, // TEMPORARILY REMOVED
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'time_clock_change_request', 'Time Clock Change Request Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send time clock change request email: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Your time clock change request has been submitted successfully!',
                    'data' => [
                        'id' => $timeClockChangeRequest->id,
                    ]
                ], 200);

            } catch (\Exception $e) {
                // Log error
                Log::error('Time clock change request submission failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting your form. Please try again later.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        // Handle GET request - Show form
        return view('frontend.pages.forms.time_clock_change_request_form');
    }

    /**
     * Supply Order Form - Display and Submit
     */
    public function supplyOrder(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation rules
                $validator = Validator::make($request->all(), [
                    'choose_your_center' => 'required|string|in:seminole,pinellas_park,largo,st_petersburg,montessori',
                    'other' => 'nullable|string|max:5000',
                ], [
                    'choose_your_center.required' => 'Please choose your center.',
                    'choose_your_center.in' => 'Please select a valid center.',
                ]);

                // If validation fails, return back with errors
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // Collect all order items (only non-zero values)
                $orderItems = [];
                $allFields = $request->all();

                foreach ($allFields as $key => $value) {
                    // Skip system fields
                    if (in_array($key, ['_token', 'choose_your_center', 'other'])) {
                        continue;
                    }

                    // Only include numeric values > 0
                    if (is_numeric($value) && (int) $value > 0) {
                        $orderItems[$key] = (int) $value;
                    }
                }

                // Check if at least one item is ordered
                if (empty($orderItems)) {
                    return back()
                        ->withErrors(['order_items' => 'Please order at least one item.'])
                        ->withInput();
                }

                // Create supply order
                $order = SupplyOrder::create([
                    'location' => $request->choose_your_center,
                    'order_items' => $orderItems,
                    'other' => $request->other,
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'choose_your_center' => ucwords(str_replace('_', ' ', $request->choose_your_center)),
                        'order_items' => $orderItems,
                        'other' => $request->other,
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'supply_order', 'Supply Order Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send supply order email: ' . $e->getMessage());
                }

                // Log success
                Log::info('Supply order submitted', [
                    'id' => $order->id,
                    'location' => $order->location,
                ]);

                return redirect()->route('frontend.thankYou')
                    ->with('success', 'Your supply order has been submitted successfully!');

            } catch (\Exception $e) {
                // Log error
                Log::error('Supply order submission failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return back()
                    ->withErrors(['error' => 'An error occurred while submitting your form. Please try again later.'])
                    ->withInput();
            }
        }

        // Handle GET request - Show form
        $formFields = [
            'number_inputs' => [
                'left_column' => [
                    'placemats' => ['label' => 'Placemats', 'required' => true],
                    'napkins' => ['label' => 'Napkins', 'required' => true],
                    'large_paper_plates' => ['label' => 'Large Paper Plates', 'required' => true],
                    'five_oz_snack_cups' => ['label' => '5 Oz Snack Cups', 'required' => true],
                    'cups' => ['label' => 'Cups', 'required' => true],
                    'forks' => ['label' => 'Forks', 'required' => true],
                    'coffee_filters' => ['label' => 'Coffee Filters', 'required' => true],
                    'trash_bags' => ['label' => 'Trash Bags', 'required' => true],
                    'poly_gloves' => ['label' => 'Poly Gloves', 'required' => true],
                    'large_baggies_gallon_ziploc' => ['label' => 'Large Baggies (Gallon Ziploc)', 'required' => true],
                    'white_paper_bags' => ['label' => 'White Paper Bags', 'required' => true],
                    'lysol' => ['label' => 'Lysol', 'required' => true],
                    'fabuloso' => ['label' => 'Fabuloso', 'required' => true],
                    'bleach' => ['label' => 'Bleach', 'required' => true],
                    'air_freshner' => ['label' => 'Air Freshner', 'required' => true],
                    'thirty_three_gallon_trash_bags_st_pete' => ['label' => '33 Gallon Trash Bags (St Pete)', 'required' => true],
                    'fifty_gallon_trash_bags_st_pete_playground' => ['label' => '50 Gallon Trash Bags (St Pete Playground)', 'required' => true],
                    'tin_pans' => ['label' => 'Tin Pans', 'required' => true],
                    'receipt_book' => ['label' => 'Receipt Book', 'required' => true],
                    'sticky_notes' => ['label' => 'Sticky Notes', 'required' => true],
                    'note_pads' => ['label' => 'Note Pads', 'required' => true],
                    'color_printer_ink' => ['label' => 'Color Printer Ink', 'required' => true],
                ],
                'right_column' => [
                    'choose_your_center' => [
                        'label' => 'Choose Your Center',
                        'required' => true,
                        'type' => 'select',
                        'options' => [
                            'seminole' => 'Seminole',
                            'pinellas_park' => 'Pinellas Park',
                            'largo' => 'Largo',
                            'st_petersburg' => 'St. Petersburg',
                            'montessori' => 'Montessori'
                        ],
                        'default' => 'seminole'
                    ],
                    'small_paper_plates' => ['label' => 'Small Paper Plates', 'required' => true],
                    'bowls' => ['label' => 'Bowls', 'required' => true],
                    'three_oz_water_cups' => ['label' => '3 Oz Water Cups', 'required' => true],
                    'spoons' => ['label' => 'Spoons', 'required' => true],
                    'paper_cupcake_holders' => ['label' => 'Paper Cupcake Holders', 'required' => true],
                    'paper_towels_for_dispenser' => ['label' => 'Paper Towels (For Dispenser)', 'required' => true],
                    'tissues' => ['label' => 'Tissues', 'required' => true],
                    'vinyl_gloves' => ['label' => 'Vinyl Gloves', 'required' => true],
                    'sandwich_bags' => ['label' => 'Sandwich Bags', 'required' => true],
                    'staples' => ['label' => 'Staples', 'required' => true],
                    'ricoh_toner' => ['label' => 'Ricoh Toner', 'required' => true],
                    'copy_paper' => ['label' => 'Copy Paper', 'required' => true],
                    'hand_soap' => ['label' => 'Hand Soap', 'required' => true],
                    'dish_soap' => ['label' => 'Dish Soap', 'required' => true],
                    'toilet_paper' => ['label' => 'Toilet Paper', 'required' => true],
                    'paper_towels_rolls' => ['label' => 'Paper Towels (Rolls)', 'required' => true],
                    'windex' => ['label' => 'Windex', 'required' => true],
                    'clorox_wipes' => ['label' => 'Clorox Wipes', 'required' => true],
                    'small_baggies_sandwich_ziploc' => ['label' => 'Small Baggies (Sandwich Ziploc)', 'required' => true],
                    'black_paper_bags' => ['label' => 'Black Paper Bags', 'required' => true],
                    'black_printer_ink' => ['label' => 'Black Printer Ink', 'required' => true],
                ]
            ],
            'textarea' => [
                'other' => [
                    'label' => 'Other (Describe In Detail And Give Quantity Needed)',
                    'required' => false,
                    'placeholder' => 'Type here'
                ]
            ]
        ];

        return view('frontend.pages.forms.supply_order_form', compact('formFields'));
    }

    /**
     * Snack Order Form - Display and Submit
     */
    public function snackOrder(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation rules
                $validator = Validator::make($request->all(), [
                    'choose_your_center' => 'required|string|in:seminole,pinellas_park,largo,st_petersburg,montessori',
                    'other' => 'nullable|string|max:5000',
                ], [
                    'choose_your_center.required' => 'Please choose your center.',
                    'choose_your_center.in' => 'Please select a valid center.',
                ]);

                // If validation fails, return back with errors
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // Collect all order items (only non-zero values)
                $orderItems = [];
                $allFields = $request->all();

                foreach ($allFields as $key => $value) {
                    // Skip system fields
                    if (in_array($key, ['_token', 'choose_your_center', 'other'])) {
                        continue;
                    }

                    // Only include numeric values > 0
                    if (is_numeric($value) && (int) $value > 0) {
                        $orderItems[$key] = (int) $value;
                    }
                }

                // Check if at least one item is ordered
                if (empty($orderItems)) {
                    return back()
                        ->withErrors(['order_items' => 'Please order at least one item.'])
                        ->withInput();
                }

                // Create snack order
                $order = SnackOrder::create([
                    'location' => $request->choose_your_center,
                    'order_items' => $orderItems,
                    'other' => $request->other,
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'choose_your_center' => ucwords(str_replace('_', ' ', $request->choose_your_center)),
                        'order_items' => $orderItems,
                        'other' => $request->other,
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'snack_order', 'Snack Order Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send snack order email: ' . $e->getMessage());
                }

                // Log success
                Log::info('Snack order submitted', [
                    'id' => $order->id,
                    'location' => $order->location,
                ]);

                return redirect()->route('frontend.thankYou')
                    ->with('success', 'Your snack order has been submitted successfully!');

            } catch (\Exception $e) {
                // Log error
                Log::error('Snack order submission failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return back()
                    ->withErrors(['error' => 'An error occurred while submitting your form. Please try again later.'])
                    ->withInput();
            }
        }

        // Handle GET request - Show form
        $formFields = [
            'number_inputs' => [
                'left_column' => [
                    // Image 1 fields
                    'cereal' => ['label' => 'Cereal', 'required' => true],
                    'pancakes' => ['label' => 'Pancakes', 'required' => true],
                    'animal_crackers' => ['label' => 'Animal Crackers', 'required' => true],
                    'pretzels' => ['label' => 'Pretzels', 'required' => true],
                    'plain_bread' => ['label' => 'Plain Bread', 'required' => true],
                    'graham_crackers' => ['label' => 'Graham Crackers', 'required' => true],
                    'nutri_grain_bars' => ['label' => 'Nutri Grain Bars', 'required' => true],
                    // Image 2 & 3 fields
                    'goldfish' => ['label' => 'Goldfish', 'required' => true],
                    'french_toast' => ['label' => 'French Toast', 'required' => true],
                    'ritz_crackers' => ['label' => 'Ritz Crackers', 'required' => true],
                    'apple_juice' => ['label' => 'Apple Juice', 'required' => true],
                    'apple' => ['label' => 'Apple', 'required' => true],
                    'cuties_oranges' => ['label' => 'Cuties Oranges', 'required' => true],
                    'muffins' => ['label' => 'Muffins', 'required' => true],
                ],
                'right_column' => [
                    'choose_your_center' => [
                        'label' => 'Choose Your Center',
                        'required' => true,
                        'type' => 'select',
                        'options' => [
                            'seminole' => 'Seminole',
                            'pinellas_park' => 'Pinellas Park',
                            'largo' => 'Largo',
                            'st_petersburg' => 'St. Petersburg',
                            'montessori' => 'Montessori'
                        ],
                        'default' => 'seminole'
                    ],
                    // Image 1 fields
                    'vanilla_wafers_nilas' => ['label' => 'Vanilla Wafers/Nilas', 'required' => true],
                    'waffles' => ['label' => 'Waffles', 'required' => true],
                    'veggie_straws' => ['label' => 'Veggie Straws', 'required' => true],
                    'raisin_toast' => ['label' => 'Raisin Toast', 'required' => true],
                    'cheese_sticks' => ['label' => 'Cheese Sticks', 'required' => true],
                    'chex_mix' => ['label' => 'Chex Mix', 'required' => true],
                    'cheez_its' => ['label' => 'Cheez Its', 'required' => true],
                    // Image 2 & 3 fields
                    'raisins_or_craisins' => ['label' => 'Raisins Or Craisins', 'required' => true],
                    'yogurt_tubs_or_go_gurts' => ['label' => 'Yogurt Tubs Or Go-Gurts', 'required' => true],
                    'applesauce' => ['label' => 'Applesauce', 'required' => true],
                    'strawberries' => ['label' => 'Strawberries', 'required' => true],
                    'orange_juice' => ['label' => 'Orange Juice', 'required' => true],
                    'english_muffins' => ['label' => 'English Muffins', 'required' => true],
                    'granola_bars' => ['label' => 'Granola Bars', 'required' => true],
                ]
            ],
            'textarea' => [
                'other' => [
                    'label' => 'Other (Describe In Detail And Give Quantity Needed)',
                    'required' => false,
                    'placeholder' => 'Type here'
                ]
            ]
        ];

        return view('frontend.pages.forms.snack_order_form', compact('formFields'));
    }

    /**
     * Standard T-Shirt Order Form - Display and Submit
     */
    public function standardTShirtOrder(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation rules
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'location' => 'required|string|in:seminole,pinellas_park,largo,st_petersburg,montessori',
                    'size' => 'required|string|in:small,medium,large,xlarge,xxlarge',
                    'colors' => 'required|array|min:1',
                    'colors.*' => 'string',
                    'special_instructions' => 'nullable|string|max:5000',
                ], [
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'location.required' => 'Location is required.',
                    'location.in' => 'Please select a valid location.',
                    'size.required' => 'Size is required.',
                    'size.in' => 'Please select a valid size.',
                    'colors.required' => 'Please select at least one color.',
                    'colors.array' => 'Colors must be an array.',
                    'colors.min' => 'Please select at least one color.',
                ]);

                // If validation fails, return back with errors
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // Create standard t-shirt order
                $order = StandardTShirtOrder::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'location' => $request->location,
                    'size' => $request->size,
                    'colors' => $request->colors,
                    'special_instructions' => $request->special_instructions,
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'location' => ucwords(str_replace('_', ' ', $request->location)),
                        'size' => ucwords($request->size),
                        'colors' => is_array($request->colors) ? implode(', ', $request->colors) : $request->colors,
                        'special_instructions' => $request->special_instructions,
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'standard_t_shirt_order', 'Standard T-Shirt Order Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send standard t-shirt order email: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Your standard t-shirt order has been submitted successfully!',
                    'data' => [
                        'id' => $order->id,
                    ]
                ], 200);

            } catch (\Exception $e) {
                // Log error
                Log::error('Standard t-shirt order submission failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting your form. Please try again later.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        // Handle GET request - Show form
        return view('frontend.pages.forms.standard_t_shirt_order_form');
    }

    /**
     * Specialty T-Shirt Order Form - Display and Submit
     */
    public function specialtyTShirtOrder(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation rules
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'location' => 'required|string|in:seminole,pinellas_park,largo,st_petersburg,montessori',
                    'size' => 'required|string|in:small,medium,large,xlarge,xxlarge',
                    'themes' => 'required|array|min:1',
                    'themes.*' => 'string',
                    'special_instructions' => 'nullable|string|max:5000',
                ], [
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'location.required' => 'Location is required.',
                    'location.in' => 'Please select a valid location.',
                    'size.required' => 'Size is required.',
                    'size.in' => 'Please select a valid size.',
                    'themes.required' => 'Please select at least one theme/holiday.',
                    'themes.array' => 'Themes must be an array.',
                    'themes.min' => 'Please select at least one theme/holiday.',
                ]);

                // If validation fails, return back with errors
                if ($validator->fails()) {
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // Create specialty t-shirt order
                $order = SpecialtyTShirtOrder::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'location' => $request->location,
                    'size' => $request->size,
                    'themes' => $request->themes,
                    'special_instructions' => $request->special_instructions,
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'location' => ucwords(str_replace('_', ' ', $request->location)),
                        'size' => ucwords($request->size),
                        'themes' => is_array($request->themes) ? implode(', ', $request->themes) : $request->themes,
                        'special_instructions' => $request->special_instructions,
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'specialty_t_shirt_order', 'Specialty T-Shirt Order Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send specialty t-shirt order email: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Your specialty t-shirt order has been submitted successfully!',
                    'data' => [
                        'id' => $order->id,
                    ]
                ], 200);

            } catch (\Exception $e) {
                // Log error
                Log::error('Specialty t-shirt order submission failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting your form. Please try again later.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        // Handle GET request - Show form
        return view('frontend.pages.forms.specialty_t_shirt_order_form');
    }

    /**
     * Subscribe to Newsletter
     */
    public function subscribeNewsletter(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:newsletter_subscriptions,email',
            ], [
                'name.required' => 'Name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already subscribed to our newsletter.',
            ]);

            // If validation fails, return errors
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed. Please check your input.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create newsletter subscription
            $subscription = NewsletterSubscription::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Send email notification
            try {
                $formData = FormEmailHelper::formatFormData([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                GraphMailer::sendFormSubmission(FormEmailHelper::getFormEmail('newsletter'), 'newsletter_subscription', 'New Newsletter Subscription', $formData);
            } catch (\Exception $e) {
                Log::error('Failed to send newsletter subscription email: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing to our newsletter!',
                'data' => [
                    'id' => $subscription->id,
                ]
            ], 200);

        } catch (\Exception $e) {
            // Log error
            Log::error('Newsletter subscription failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while subscribing. Please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Employment Application Form - Display and Submit
     */
    public function employmentApplication(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation rules
                $validator = Validator::make($request->all(), [
                    'position' => 'required|string|in:teacher,assistant_teacher,director,substitute,other',
                    'location' => 'required|string|in:seminole,pinellas_park,largo,st_petersburg,montessori',
                    'start_date' => 'nullable|date',
                    'resume' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
                    'salary_dollars' => 'required|string|max:10|regex:/^\d+$/',
                    'salary_cents' => 'required|string|max:10|regex:/^\d{2}$/',
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'phone' => 'required|string|max:20',
                ], [
                    'position.required' => 'Please select a position.',
                    'position.in' => 'Please select a valid position.',
                    'location.required' => 'Please select a location.',
                    'location.in' => 'Please select a valid location.',
                    'start_date.date' => 'Start date must be a valid date.',
                    'resume.required' => 'Please attach your resume.',
                    'resume.file' => 'The resume must be a valid file.',
                    'resume.mimes' => 'The resume must be a PDF, DOC, or DOCX file.',
                    'resume.max' => 'The resume file size must not exceed 10MB.',
                    'salary_dollars.required' => 'Please select salary dollars.',
                    'salary_dollars.regex' => 'Salary dollars must be a valid number.',
                    'salary_cents.required' => 'Please select salary cents.',
                    'salary_cents.regex' => 'Salary cents must be a valid two-digit number.',
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'email.required' => 'Email address is required.',
                    'email.email' => 'Please enter a valid email address.',
                    'phone.required' => 'Phone number is required.',
                ]);

                // If validation fails, return JSON response for AJAX
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please correct the errors below.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                // Handle file upload
                $resumePath = null;
                if ($request->hasFile('resume')) {
                    $file = $request->file('resume');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $resumePath = $file->storeAs('employment_applications', $fileName, 'public');
                }

                // Create employment application
                $application = EmploymentApplication::create([
                    'position' => $request->position,
                    'location' => $request->location,
                    'start_date' => $request->start_date,
                    'resume_path' => $resumePath,
                    'salary_dollars' => $request->salary_dollars,
                    'salary_cents' => $request->salary_cents,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                // Send email notification
                try {
                    $salary = '$' . $request->salary_dollars . '.' . $request->salary_cents;
                    $formData = FormEmailHelper::formatFormData([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'position' => ucwords(str_replace('_', ' ', $request->position)),
                        'location' => ucwords(str_replace('_', ' ', $request->location)),
                        'start_date' => $request->start_date,
                        'salary' => $salary,
                        'resume' => $resumePath ? 'Resume attached' : null,
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getFormEmail('employment'), 'employment_application', 'Employment Application Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send employment application email: ' . $e->getMessage());
                }

                // Log success
                Log::info('Employment application submitted', [
                    'id' => $application->id,
                    'email' => $application->email,
                    'position' => $application->position,
                    'location' => $application->location,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Your employment application has been submitted successfully!',
                    'data' => [
                        'id' => $application->id,
                    ]
                ], 200);

            } catch (\Exception $e) {
                // Log error
                Log::error('Employment application submission failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting your form. Please try again later.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
        }

        // Handle GET request - Show form
        return view('frontend.pages.forms.employment_application_form');
    }

}
