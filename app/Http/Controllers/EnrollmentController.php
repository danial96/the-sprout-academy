<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\EnrollmentContact;
use App\Models\EnrollmentChild;
use App\Models\EnrollmentAddress;
use App\Models\EnrollmentPhone;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormSubmissionMail;
use App\Helpers\FormEmailHelper;
use App\Helpers\BrevoMailer;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    // Location data configuration
    private function getLocationData($location)
    {
        // Normalize location slug to handle both underscore and hyphen formats
        $location = str_replace('_', '-', strtolower($location));
        
        $locations = [
            'seminole' => [
                'name' => 'SEMINOLE',
                'address' => '9259 Park Blvd Seminole, FL 33777',
                'phone' => '727-399-2483',
                'map_address' => '9259 Park Blvd Seminole, FL 33777',
            ],
            'clearwater' => [
                'name' => 'CLEARWATER',
                'address' => '7985 113th St N, Seminole, FL 33772',
                'phone' => '(727) 953-5544',
                'map_address' => '7985 113th St N, Seminole, FL 33772',
            ],
            'pinellas-park' => [
                'name' => 'PINELLAS PARK',
                'address' => '7985 113th St N, Seminole, FL 33772',
                'phone' => '(727) 953-5544',
                'map_address' => '7985 113th St N, Seminole, FL 33772',
            ],
            'largo' => [
                'name' => 'LARGO',
                'address' => '7985 113th St N, Seminole, FL 33772',
                'phone' => '(727) 953-5544',
                'map_address' => '7985 113th St N, Seminole, FL 33772',
            ],
            'st-petersburg' => [
                'name' => 'ST. PETERSBURG',
                'address' => '7985 113th St N, Seminole, FL 33772',
                'phone' => '(727) 953-5544',
                'map_address' => '7985 113th St N, Seminole, FL 33772',
            ],
            'montessori' => [
                'name' => 'MONTESSORI',
                'address' => '7985 113th St N, Seminole, FL 33772',
                'phone' => '(727) 953-5544',
                'map_address' => '7985 113th St N, Seminole, FL 33772',
            ],
        ];

        return $locations[$location] ?? $locations['seminole'];
    }

    /**
     * Show initial location enrollment form (Email collection)
     */
    public function showLocationEnrollmentForm(Request $request, $location)
    {
        $locationData = $this->getLocationData($location);
        
        // Capture referrer from query parameter (ref=locations or ref=virtual-tour)
        $referrer = $request->query('ref', null);
        if ($referrer) {
            $request->session()->put('enrollment_referrer', $referrer);
        } else {
            // If no ref parameter, check session
            $referrer = $request->session()->get('enrollment_referrer');
        }

        return view('frontend.pages.enrollment.location_enrollment_form', [
            'location' => $location,
            'locationData' => $locationData,
            'referrer' => $referrer,
        ]);
    }

    /**
     * Handle initial enrollment form submission (Email + Privacy Policy)
     */
    public function startEnrollment(Request $request, $location)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'privacy_policy' => 'required|accepted',
                'referrer' => 'nullable|string|max:255',
            ], [
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
                'privacy_policy.required' => 'You must agree to the Privacy Policy to continue.',
                'privacy_policy.accepted' => 'You must agree to the Privacy Policy to continue.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please correct the errors below.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Save referrer to session
            if ($request->referrer) {
                $request->session()->put('enrollment_referrer', $request->referrer);
            }

            // Save email to session (will be used in step1)
            $request->session()->put('enrollment_email', $request->email);

            // Redirect to step1 enrollment form
            return response()->json([
                'success' => true,
                'message' => 'Email saved successfully.',
                'redirect_url' => route('enrollment.form', ['location' => $location])
            ], 200);

        } catch (\Exception $e) {
            Log::error('Location enrollment start failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Show enrollment form - Step 1 (Account Info)
     */
    public function showEnrollmentForm(Request $request, $location)
    {
        $locationData = $this->getLocationData($location);
        $enrollmentId = $request->session()->get('enrollment_id');
        $enrollment = null;
        $primaryContact = null;
        $address = null;
        $phones = collect([]); // Initialize as collection

        // Capture referrer from query parameter (ref=locations or ref=virtual-tour)
        $referrer = $request->query('ref', null);
        if ($referrer) {
            $request->session()->put('enrollment_referrer', $referrer);
        } else {
            // If no ref parameter, check session
            $referrer = $request->session()->get('enrollment_referrer');
        }

        if ($enrollmentId) {
            $enrollment = Enrollment::with([
                'contacts' => function ($query) {
                $query->where('is_primary', true);
                },
                'addresses',
                'phones'
            ])->find($enrollmentId);
            if ($enrollment) {
                $primaryContact = $enrollment->contacts ? $enrollment->contacts->where('is_primary', true)->first() : null;
                $address = $enrollment->addresses()->where('is_physical', true)->first();
                $phones = $enrollment->phones ?: collect([]);
            }
        }

        return view('frontend.pages.enrollment.step1_account_info', [
            'location' => $location,
            'locationData' => $locationData,
            'enrollment' => $enrollment,
            'primaryContact' => $primaryContact,
            'address' => $address,
            'phones' => $phones,
            'currentStep' => 1,
            'referrer' => $referrer,
        ]);
    }

    /**
     * Save Step 1 - Account Info
     */
    public function saveStep1(Request $request, $location)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_initial' => 'nullable|string|max:1',
                'gender' => 'nullable|in:male,female,other',
                'date_of_birth' => 'nullable|date',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address_line_1' => 'nullable|string|max:255',
                'address_line_2' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'zip_code' => 'nullable|string|max:10',
                'is_physical' => 'nullable|boolean',
                'is_mailing' => 'nullable|boolean',
                'phone_type.*' => 'nullable|string|max:50',
                'phone_area_code.*' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (!empty($value) && (!preg_match('/^[0-9]{3}$/', $value))) {
                            $fail('The area code must be exactly 3 digits.');
                        }
                    },
                ],
                'phone_number.*' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        if (!empty($value)) {
                            // Remove dashes and check if exactly 7 digits
                            $digits = preg_replace('/[^0-9]/', '', $value);
                            if (strlen($digits) !== 7) {
                                $fail('The phone number must be 7 digits (without area code).');
                            }
                        }
                    },
                ],
                'referrer' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Get or create enrollment
            $enrollmentId = $request->session()->get('enrollment_id');
            $referrer = $request->input('referrer') ?? $request->session()->get('enrollment_referrer');

            if ($enrollmentId) {
                $enrollment = Enrollment::find($enrollmentId);
                // Update referrer if not already set
                if ($enrollment && !$enrollment->referrer && $referrer) {
                    $enrollment->update(['referrer' => $referrer]);
                }
            } else {
                $enrollment = Enrollment::create([
                    'location' => $location,
                    'referrer' => $referrer,
                    'status' => 'draft',
                    'current_step' => 1,
                ]);
                $request->session()->put('enrollment_id', $enrollment->id);
            }

            // Handle profile image upload
            $profileImagePath = null;
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $profileImagePath = $file->storeAs('enrollments/profiles', $filename, 'public');
            }

            // Create or update primary contact
            $primaryContact = $enrollment->primaryContact;
            if (!$primaryContact) {
                $primaryContact = EnrollmentContact::create([
                    'enrollment_id' => $enrollment->id,
                    'first_name' => $request->first_name,
                    'middle_initial' => $request->middle_initial,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'date_of_birth' => $request->date_of_birth,
                    'profile_image' => $profileImagePath,
                    'is_primary' => true,
                    'contact_order' => 0,
                ]);
            } else {
                $updateData = [
                    'first_name' => $request->first_name,
                    'middle_initial' => $request->middle_initial,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'date_of_birth' => $request->date_of_birth,
                ];
                // Update profile image only if a new file is uploaded
                if ($profileImagePath) {
                    $updateData['profile_image'] = $profileImagePath;
                }
                $primaryContact->update($updateData);
            }

            // Handle address
            if ($request->address_line_1) {
                $address = $enrollment->addresses()->where('is_physical', true)->first();
                if (!$address) {
                    EnrollmentAddress::create([
                        'enrollment_id' => $enrollment->id,
                        'enrollment_contact_id' => $primaryContact->id,
                        'address_line_1' => $request->address_line_1,
                        'address_line_2' => $request->address_line_2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code,
                        'is_physical' => $request->is_physical ?? true,
                        'is_mailing' => $request->is_mailing ?? false,
                    ]);
                } else {
                    $address->update([
                        'address_line_1' => $request->address_line_1,
                        'address_line_2' => $request->address_line_2,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip_code' => $request->zip_code,
                        'is_physical' => $request->is_physical ?? true,
                        'is_mailing' => $request->is_mailing ?? false,
                    ]);
                }
            }

            // Handle phones
            if ($request->phone_type) {
                // Delete existing phones for this contact
                $enrollment->phones()->where('enrollment_contact_id', $primaryContact->id)->delete();
                
                foreach ($request->phone_type as $index => $type) {
                    if ($type && isset($request->phone_area_code[$index]) && isset($request->phone_number[$index])) {
                        $areaCode = $request->phone_area_code[$index];
                        $phoneNumber = $request->phone_number[$index];
                        
                        // Ensure area code is exactly 3 digits
                        $areaCode = preg_replace('/[^0-9]/', '', $areaCode);
                        if (strlen($areaCode) !== 3) {
                            continue; // Skip invalid area code
                        }
                        
                        // Clean phone number - remove dashes and ensure it's 7 digits (no area code)
                        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
                        // If phone number has more than 7 digits, it might include area code - remove first 3 digits
                        if (strlen($phoneNumber) > 7) {
                            $phoneNumber = substr($phoneNumber, -7); // Take last 7 digits
                        }
                        // Ensure exactly 7 digits
                        if (strlen($phoneNumber) !== 7) {
                            continue; // Skip invalid phone number
                        }
                        
                        EnrollmentPhone::create([
                            'enrollment_id' => $enrollment->id,
                            'enrollment_contact_id' => $primaryContact->id,
                            'type' => $type,
                            'area_code' => $areaCode,
                            'phone_number' => $phoneNumber,
                            'phone_order' => $index,
                        ]);
                    }
                }
            }

            // Update enrollment step
            $enrollment->update(['current_step' => 1]);

            // Determine next step based on action (review or step2)
            $nextStep = $request->input('next_step', 2); // Default to step 2
            $redirectUrl = $nextStep == 4 
                ? route('enrollment.step4', ['location' => $location])
                : route('enrollment.step2', ['location' => $location]);

            return response()->json([
                'success' => true,
                'message' => 'Account information saved successfully.',
                'data' => [
                    'enrollment_id' => $enrollment->id,
                    'next_step' => $nextStep,
                    'redirect_url' => $redirectUrl
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Enrollment Step 1 save failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Show Step 2 - Children Info
     */
    public function showStep2(Request $request, $location)
    {
        $locationData = $this->getLocationData($location);
        $enrollmentId = $request->session()->get('enrollment_id');
        
        if (!$enrollmentId) {
            return redirect()->route('enrollment.form', ['location' => $location]);
        }

        $enrollment = Enrollment::with([
            'children' => function ($query) {
                $query->orderBy('child_order');
            },
        ])->find($enrollmentId);
        if (!$enrollment) {
            return redirect()->route('enrollment.form', ['location' => $location]);
        }

        return view('frontend.pages.enrollment.step2_children_info', [
            'location' => $location,
            'locationData' => $locationData,
            'enrollment' => $enrollment,
            'children' => $enrollment->children ?: collect([]),
            'currentStep' => 2,
        ]);
    }

    /**
     * Save Step 2 - Children Info
     */
    public function saveStep2(Request $request, $location)
    {
        try {
            $validator = Validator::make($request->all(), [
                'child_first_name.*' => 'required|string|max:255',
                'child_last_name.*' => 'required|string|max:255',
                'child_middle_initial.*' => 'nullable|string|max:1',
                'child_gender.*' => 'nullable|in:male,female,other',
                'child_date_of_birth.*' => 'nullable|date',
                'child_profile_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $enrollmentId = $request->session()->get('enrollment_id');
            if (!$enrollmentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollment session expired. Please start over.',
                ], 400);
            }

            $enrollment = Enrollment::find($enrollmentId);
            if (!$enrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollment not found.',
                ], 404);
            }

            // Delete existing children
            $enrollment->children()->delete();

            // Create new children
            if ($request->child_first_name) {
                foreach ($request->child_first_name as $index => $firstName) {
                    $profileImagePath = null;
                    if ($request->hasFile("child_profile_image.$index")) {
                        $file = $request->file("child_profile_image.$index");
                        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
                        $profileImagePath = $file->storeAs('enrollments/children', $filename, 'public');
                    }

                    EnrollmentChild::create([
                        'enrollment_id' => $enrollment->id,
                        'first_name' => $firstName,
                        'middle_initial' => $request->child_middle_initial[$index] ?? null,
                        'last_name' => $request->child_last_name[$index],
                        'gender' => $request->child_gender[$index] ?? null,
                        'date_of_birth' => $request->child_date_of_birth[$index] ?? null,
                        'profile_image' => $profileImagePath,
                        'child_order' => $index,
                    ]);
                }
            }

            $enrollment->update(['current_step' => 2]);

            return response()->json([
                'success' => true,
                'message' => 'Children information saved successfully.',
                'data' => [
                    'enrollment_id' => $enrollment->id,
                    'next_step' => 3,
                    'redirect_url' => route('enrollment.step3', ['location' => $location])
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Enrollment Step 2 save failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Show Step 3 - Emergency Contacts
     */
    public function showStep3(Request $request, $location)
    {
        $locationData = $this->getLocationData($location);
        $enrollmentId = $request->session()->get('enrollment_id');
        
        if (!$enrollmentId) {
            return redirect()->route('enrollment.form', ['location' => $location]);
        }

        $enrollment = Enrollment::with([
            'contacts' => function ($query) {
                $query->where('is_primary', false)->orderBy('contact_order');
            },
        ])->find($enrollmentId);

        if (!$enrollment) {
            return redirect()->route('enrollment.form', ['location' => $location]);
        }

        return view('frontend.pages.enrollment.step3_emergency_contacts', [
            'location' => $location,
            'locationData' => $locationData,
            'enrollment' => $enrollment,
            'contacts' => $enrollment->contacts ?: collect([]),
            'currentStep' => 3,
        ]);
    }

    /**
     * Save Step 3 - Emergency Contacts
     */
    public function saveStep3(Request $request, $location)
    {
        try {
            $validator = Validator::make($request->all(), [
                'contact_first_name.*' => 'required|string|max:255',
                'contact_last_name.*' => 'required|string|max:255',
                'contact_middle_initial.*' => 'nullable|string|max:1',
                'contact_gender.*' => 'nullable|in:male,female,other',
                'contact_date_of_birth.*' => 'nullable|date',
                'contact_relationship_type.*' => 'nullable|string|max:255',
                'contact_lives_with.*' => 'nullable|boolean',
                'contact_is_emergency.*' => 'nullable|boolean',
                'contact_is_pickup.*' => 'nullable|boolean',
                'contact_profile_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $enrollmentId = $request->session()->get('enrollment_id');
            if (!$enrollmentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollment session expired. Please start over.',
                ], 400);
            }

            $enrollment = Enrollment::find($enrollmentId);
            if (!$enrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollment not found.',
                ], 404);
            }

            // Delete existing non-primary contacts
            $enrollment->contacts()->where('is_primary', false)->delete();

            // Create new emergency contacts
            if ($request->contact_first_name) {
                // Get all checkbox arrays - these may have missing indices for unchecked boxes
                $livesWith = $request->contact_lives_with ?? [];
                $isEmergency = $request->contact_is_emergency ?? [];
                $isPickup = $request->contact_is_pickup ?? [];

                foreach ($request->contact_first_name as $index => $firstName) {
                    $profileImagePath = null;
                    if ($request->hasFile("contact_profile_image.$index")) {
                        $file = $request->file("contact_profile_image.$index");
                        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
                        $profileImagePath = $file->storeAs('enrollments/contacts', $filename, 'public');
                    }

                    // Handle checkbox values - checkboxes only send values when checked
                    // So we check if the index exists in the array and if the value is truthy
                    $livesWithValue = false;
                    if (isset($livesWith[$index])) {
                        $val = $livesWith[$index];
                        $livesWithValue = ($val == "1" || $val === true || $val === 1 || $val === "on");
                    }

                    $isEmergencyValue = false;
                    if (isset($isEmergency[$index])) {
                        $val = $isEmergency[$index];
                        $isEmergencyValue = ($val == "1" || $val === true || $val === 1 || $val === "on");
                    }

                    $isPickupValue = false;
                    if (isset($isPickup[$index])) {
                        $val = $isPickup[$index];
                        $isPickupValue = ($val == "1" || $val === true || $val === 1 || $val === "on");
                    }

                    EnrollmentContact::create([
                        'enrollment_id' => $enrollment->id,
                        'first_name' => $firstName,
                        'middle_initial' => $request->contact_middle_initial[$index] ?? null,
                        'last_name' => $request->contact_last_name[$index] ?? '',
                        'gender' => $request->contact_gender[$index] ?? null,
                        'date_of_birth' => $request->contact_date_of_birth[$index] ?? null,
                        'profile_image' => $profileImagePath,
                        'relationship_type' => $request->contact_relationship_type[$index] ?? null,
                        'lives_with' => $livesWithValue,
                        'is_emergency_contact' => $isEmergencyValue,
                        'is_authorized_pickup' => $isPickupValue,
                        'is_primary' => false,
                        'contact_order' => $index,
                    ]);
                }
            }

            $enrollment->update(['current_step' => 3]);

            return response()->json([
                'success' => true,
                'message' => 'Emergency contacts saved successfully.',
                'data' => [
                    'enrollment_id' => $enrollment->id,
                    'next_step' => 4,
                    'redirect_url' => route('enrollment.step4', ['location' => $location])
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Enrollment Step 3 save failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Show Step 4 - Review & Submit
     */
    public function showStep4(Request $request, $location)
    {
        $locationData = $this->getLocationData($location);
        $enrollmentId = $request->session()->get('enrollment_id');
        
        if (!$enrollmentId) {
            return redirect()->route('enrollment.form', ['location' => $location]);
        }

        $enrollment = Enrollment::with([
            'contacts' => function ($query) {
                $query->orderByDesc('is_primary')->orderBy('contact_order');
            },
            'children' => function ($query) {
                $query->orderBy('child_order');
            },
            'addresses',
            'phones',
        ])->find($enrollmentId);

        if (!$enrollment) {
            return redirect()->route('enrollment.form', ['location' => $location]);
        }

        // Check which steps are incomplete
        $hasChildren = $enrollment->children && $enrollment->children->count() > 0;
        $hasEmergencyContacts = $enrollment->contacts && $enrollment->contacts->where('is_primary', false)->count() > 0;
        
        $incompleteSteps = [];
        if (!$hasChildren) {
            $incompleteSteps[] = 2;
        }
        if (!$hasEmergencyContacts) {
            $incompleteSteps[] = 3;
        }
        
        $isComplete = empty($incompleteSteps);

        return view('frontend.pages.enrollment.step4_review', [
            'location' => $location,
            'locationData' => $locationData,
            'enrollment' => $enrollment,
            'currentStep' => 4,
            'incompleteSteps' => $incompleteSteps,
            'isComplete' => $isComplete,
        ]);
    }

    /**
     * Submit Enrollment
     */
    public function submitEnrollment(Request $request, $location)
    {
        try {
            $enrollmentId = $request->session()->get('enrollment_id');
            if (!$enrollmentId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollment session expired. Please start over.',
                ], 400);
            }

            $enrollment = Enrollment::find($enrollmentId);
            if (!$enrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollment not found.',
                ], 404);
            }

            // Get referrer from session if not already saved
            $referrer = $request->session()->get('enrollment_referrer');

            // Update enrollment status and referrer
            $updateData = [
                'status' => 'submitted',
                'current_step' => 4,
            ];

            // Update referrer if not already set or if we have a new one
            if ($referrer && (!$enrollment->referrer || $enrollment->referrer !== $referrer)) {
                $updateData['referrer'] = $referrer;
            }

            $enrollment->update($updateData);

            // Reload enrollment with all relationships for email
            $enrollment->load(['contacts', 'children', 'addresses', 'phones']);

            // Send email notification
            try {
                $primaryContact = $enrollment->contacts->where('is_primary', true)->first();
                $address = $enrollment->addresses->where('is_physical', true)->first();
                $phones = $enrollment->phones->where('enrollment_contact_id', $primaryContact?->id);

                $formData = [];
                
                // Primary Contact Info
                if ($primaryContact) {
                    $formData['Primary Contact Name'] = trim(($primaryContact->first_name ?? '') . ' ' . ($primaryContact->middle_initial ?? '') . ' ' . ($primaryContact->last_name ?? ''));
                    $formData['Primary Contact Gender'] = $primaryContact->gender ? ucfirst($primaryContact->gender) : null;
                    $formData['Primary Contact Date of Birth'] = $primaryContact->date_of_birth ? $primaryContact->date_of_birth->format('F j, Y') : null;
                }

                // Address
                if ($address) {
                    $formData['Address Line 1'] = $address->address_line_1;
                    $formData['Address Line 2'] = $address->address_line_2;
                    $formData['City'] = $address->city;
                    $formData['State'] = $address->state;
                    $formData['Zip Code'] = $address->zip_code;
                }

                // Phones
                if ($phones && $phones->count() > 0) {
                    $phoneList = [];
                    foreach ($phones as $phone) {
                        $phoneList[] = ucfirst($phone->type) . ': (' . $phone->area_code . ') ' . $phone->phone_number;
                    }
                    $formData['Phone Numbers'] = implode(', ', $phoneList);
                }

                // Children
                if ($enrollment->children && $enrollment->children->count() > 0) {
                    $childrenList = [];
                    foreach ($enrollment->children as $index => $child) {
                        $childName = trim(($child->first_name ?? '') . ' ' . ($child->middle_initial ?? '') . ' ' . ($child->last_name ?? ''));
                        $childInfo = $childName;
                        if ($child->date_of_birth) {
                            $childInfo .= ' (DOB: ' . $child->date_of_birth->format('F j, Y') . ')';
                        }
                        if ($child->gender) {
                            $childInfo .= ' - ' . ucfirst($child->gender);
                        }
                        $childrenList[] = $childInfo;
                    }
                    $formData['Children'] = implode("\n", $childrenList);
                }

                // Emergency Contacts
                $emergencyContacts = $enrollment->contacts->where('is_primary', false);
                if ($emergencyContacts && $emergencyContacts->count() > 0) {
                    $contactsList = [];
                    foreach ($emergencyContacts as $contact) {
                        $contactName = trim(($contact->first_name ?? '') . ' ' . ($contact->middle_initial ?? '') . ' ' . ($contact->last_name ?? ''));
                        $contactInfo = $contactName;
                        if ($contact->relationship_type) {
                            $contactInfo .= ' - ' . $contact->relationship_type;
                        }
                        $flags = [];
                        if ($contact->is_emergency_contact) $flags[] = 'Emergency Contact';
                        if ($contact->is_authorized_pickup) $flags[] = 'Authorized Pickup';
                        if ($contact->lives_with) $flags[] = 'Lives With';
                        if (!empty($flags)) {
                            $contactInfo .= ' (' . implode(', ', $flags) . ')';
                        }
                        $contactsList[] = $contactInfo;
                    }
                    $formData['Emergency Contacts'] = implode("\n", $contactsList);
                }

                // Other Info
                $formData['Location'] = ucwords(str_replace(['-', '_'], ' ', $location));
                $formData['Referrer'] = $enrollment->referrer ?? 'Direct';
                $formData['Enrollment ID'] = $enrollment->id;

                // Remove null values
                $formData = array_filter($formData, function($value) {
                    return $value !== null && $value !== '';
                });

                BrevoMailer::sendFormSubmission(
                    FormEmailHelper::getEnrollmentEmail($location),
                    'enrollment',
                    'New Enrollment Form Submitted',
                    $formData
                );
            } catch (\Exception $e) {
                Log::error('Failed to send enrollment email: ' . $e->getMessage());
            }

            // Clear session
            $request->session()->forget('enrollment_id');
            $request->session()->forget('enrollment_referrer');

            return response()->json([
                'success' => true,
                'message' => 'Enrollment submitted successfully!',
                'data' => [
                    'enrollment_id' => $enrollment->id,
                    'redirect_url' => route('enrollment.thankYou', ['location' => $location]),
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Enrollment submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Thank You Page
     */
    public function thankYou(Request $request, $location)
    {
        $locationData = $this->getLocationData($location);
        
        return view('frontend.pages.enrollment.thank_you', [
            'location' => $location,
            'locationData' => $locationData,
        ]);
    }
}
