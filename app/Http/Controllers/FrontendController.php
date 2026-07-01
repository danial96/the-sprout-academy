<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\ChildAbsent;
use App\Models\ChildAbsentForm;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Helpers\FormEmailHelper;
use App\Helpers\GraphMailer;

class FrontendController extends Controller
{
    public function index()
    {
        $locations = Location::active()->get();
        return view('frontend.pages.index', compact('locations'));
    }

    public function Parents()
    {
        return view('frontend.pages.parents');
    }

    public function OurPrograms()
    {
        return view('frontend.pages.programs');
    }

    public function Locations()
    {
        $locations = Location::active()->get();
        return view('frontend.pages.locations', compact('locations'));
    }

    public function Sproutvine()
    {
        return view('frontend.pages.sproutvine');
    }

    public function VirtualTour()
    {
        $locations = Location::active()->get();

        // Map location slugs to folder names
        $locationFolderMap = [
            'seminole' => 'Seminole',
            'pinellas-park' => 'Pinellas Park',
            'montessori' => 'Montessori',
            'largo' => 'Largo',
            'st-petersburg' => 'St. Pete',
            'clearwater' => 'Clearwater',
        ];

        // Get all panorama images for each location
        $panoramaImages = [];
        $panoramaImageLists = [];
        foreach ($locations as $location) {
            $folderName = $locationFolderMap[$location->slug] ?? null;
            if ($folderName) {
                $folderPath = public_path('frontend/assets/virtual-tours-images/' . $folderName);
                if (is_dir($folderPath)) {
                    $files = glob($folderPath . '/*.jpg');
                    if (!empty($files)) {
                        // Sort files
                        sort($files);
                        // Get all images with labels
                        $imageList = [];
                        foreach ($files as $file) {
                            $imageName = basename($file);
                            $imageUrl = asset('frontend/assets/virtual-tours-images/' . $folderName . '/' . $imageName);
                            // Extract label from filename
                            $filenameWithoutExt = pathinfo($imageName, PATHINFO_FILENAME);
                            // Remove location name prefix (e.g., "Seminole-1" -> "1" or "Front Office")
                            $label = str_replace([$folderName . '-', $folderName . '_', ucfirst(strtolower($folderName)) . '-'], '', $filenameWithoutExt);
                            // Replace numbers with more readable format or keep as is
                            $label = str_replace(['-', '_'], ' ', $label);
                            // If it's just a number, make it more descriptive
                            if (is_numeric(trim($label))) {
                                $label = 'View ' . trim($label);
                            }
                            $label = ucwords(trim($label));
                            // If label is empty or too short, use a default
                            if (empty($label) || strlen($label) < 2) {
                                $label = '360° View';
                            }
                            $imageList[] = [
                                'url' => $imageUrl,
                                'label' => $label,
                                'filename' => $imageName
                            ];
                        }
                        $panoramaImageLists[$location->slug] = $imageList;
                        // Set first image as default
                        $panoramaImages[$location->slug] = $imageList[0]['url'];
                    }
                }
            }
        }

        return view('frontend.pages.virtual_tour', compact('locations', 'panoramaImages', 'panoramaImageLists'));
    }

    public function TheSproutAcademyDifference()
    {
        return view('frontend.pages.sprout_academy_difference');
    }

    public function WeCareForYourChild()
    {
        return view('frontend.pages.we_care_for_your_child');
    }

    public function TuitionCosts()
    {
        return view('frontend.pages.tution_costs');
    }

    public function MeetTheTeam()
    {
        return view('frontend.pages.team');
    }

    public function MeetTheOwner()
    {
        return view('frontend.pages.meet_the_owner');
    }

    public function DownloadForms()
    {
        return view('frontend.pages.download_forms');
    }

    public function ParentsForms()
    {
        return view('frontend.pages.parents_forms');
    }


    private function getLocationPanoramaImages(string $slug): array
    {
        $locationFolderMap = [
            'seminole'      => 'Seminole',
            'pinellas-park' => 'Pinellas Park',
            'montessori'    => 'Montessori',
            'largo'         => 'Largo',
            'st-petersburg' => 'St. Pete',
            'clearwater'    => 'Clearwater',
        ];

        $folderName = $locationFolderMap[$slug] ?? null;
        if (!$folderName) return [];

        $folderPath = public_path('frontend/assets/virtual-tours-images/' . $folderName);
        if (!is_dir($folderPath)) return [];

        $files = glob($folderPath . '/*.jpg');
        if (empty($files)) return [];

        sort($files);
        $imageList = [];
        foreach ($files as $file) {
            $imageName = basename($file);
            $imageUrl  = asset('frontend/assets/virtual-tours-images/' . $folderName . '/' . $imageName);
            $label     = pathinfo($imageName, PATHINFO_FILENAME);
            $label     = str_replace([$folderName . '-', $folderName . '_'], '', $label);
            $label     = str_replace(['-', '_'], ' ', $label);
            $label     = is_numeric(trim($label)) ? 'View ' . trim($label) : $label;
            $label     = ucwords(trim($label));
            if (empty($label) || strlen($label) < 2) $label = '360° View';
            $imageList[] = ['url' => $imageUrl, 'label' => $label, 'filename' => $imageName];
        }

        return $imageList;
    }

    public function LocationSeminole()
    {
        $panoramaImages = $this->getLocationPanoramaImages('seminole');
        $location = Location::where('slug', 'seminole')->first();
        return view('frontend.pages.location_seminole', compact('panoramaImages', 'location'));
    }

    public function LocationClearwater()
    {
        $panoramaImages = $this->getLocationPanoramaImages('clearwater');
        $location = Location::where('slug', 'clearwater')->first();
        return view('frontend.pages.location_clearwater', compact('panoramaImages', 'location'));
    }

    public function LocationPinellasPark()
    {
        $panoramaImages = $this->getLocationPanoramaImages('pinellas-park');
        $location = Location::where('slug', 'pinellas-park')->first();
        return view('frontend.pages.location_pinellessPark', compact('panoramaImages', 'location'));
    }

    public function LocationMontessori()
    {
        $panoramaImages = $this->getLocationPanoramaImages('montessori');
        $location = Location::where('slug', 'montessori')->first();
        return view('frontend.pages.location_montesorri', compact('panoramaImages', 'location'));
    }

    public function LocationLargo()
    {
        $panoramaImages = $this->getLocationPanoramaImages('largo');
        $location = Location::where('slug', 'largo')->first();
        return view('frontend.pages.location_largo', compact('panoramaImages', 'location'));
    }

    public function LocationStPetersburg()
    {
        $panoramaImages = $this->getLocationPanoramaImages('st-petersburg');
        $location = Location::where('slug', 'st-petersburg')->first();
        return view('frontend.pages.location_stPetersburg', compact('panoramaImages', 'location'));
    }

    public function InfantToddlerEducation()
    {
        return view('frontend.pages.infant_toddler_education');
    }

    public function PreschoolEarlyEducation()
    {
        return view('frontend.pages.preschool_early_education');
    }

    public function EducationFor512YearOld()
    {
        return view('frontend.pages.education_for_5_12_year_old');
    }

    public function EmployeeForms()
    {
        if (!auth()->user()) {
            return redirect()->guest(route('login'));
        }

        if (auth()->user()->role !== 'employee') {
            return redirect()->route('admin.dashboard');
        }

        return view('frontend.pages.employee_forms');
    }

    public function EmployeeLoginForm()
    {
        return redirect()->route('login');
    }

    public function ThankYou()
    {
        return view('frontend.pages.thank-you');
    }

    public function Enroll()
    {
        $locations = Location::active()->get();
        return view('frontend.pages.enrollment', compact('locations'));
    }

    /**
     * "Send us a message" form on the public /enroll page (AJAX JSON).
     */
    public function submitEnrollContactMessage(Request $request)
    {
        $allowedSlugs = Location::active()->pluck('slug')->filter()->values()->all();

        if ($allowedSlugs === []) {
            return response()->json([
                'success' => false,
                'message' => 'No locations are available. Please try again later.',
            ], 422);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:10000',
            'locations' => 'required|array|min:1',
            'locations.*' => ['string', Rule::in($allowedSlugs)],
        ];

        $messages = [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'message.required' => 'Please enter a message.',
            'locations.required' => 'Please select at least one location.',
            'locations.min' => 'Please select at least one location.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $locationLabels = Location::active()
                ->whereIn('slug', $request->locations)
                ->orderBy('display_order')
                ->orderBy('name')
                ->pluck('name')
                ->implode(', ');

            $formData = FormEmailHelper::formatFormData([
                'Name' => $request->name,
                'Email' => $request->email,
                'Locations' => $locationLabels,
                'Message' => $request->message,
            ]);

            GraphMailer::sendFormSubmission(FormEmailHelper::getFormEmail('contact'), 'enroll_contact_message', 'Enroll Page — Contact Message', $formData);
        } catch (\Exception $e) {
            Log::error('Enroll contact message failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your message has been sent.',
        ], 200);
    }

    public function CorporateResponsibility()
    {
        return view('frontend.pages.corporate_responsibility');
    }

    public function NonDiscriminationPolicy()
    {
        return view('frontend.pages.non_discrimination_policy');
    }

    public function ChildAbsentForm(Request $request)
    {
        // Handle POST request - Form submission
        if ($request->isMethod('post')) {
            try {
                // Validation
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'child_first_name' => 'required|string|max:255',
                    'child_last_name' => 'required|string|max:255',
                    'phone_number' => 'required|string|max:20',
                    'location' => 'required|string|in:seminole,pinellas-park,montessori,largo,st-petersburg',
                    'date_submission' => 'required|date',
                    'date_of_expected_return' => 'required|date',
                    'reason' => 'nullable|string|max:5000',
                ], [
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'child_first_name.required' => 'Child first name is required.',
                    'child_last_name.required' => 'Child last name is required.',
                    'phone_number.required' => 'Phone number is required.',
                    'location.required' => 'Location is required.',
                    'date_submission.required' => 'Date is required.',
                    'date_submission.date' => 'Please provide a valid date.',
                    'date_of_expected_return.required' => 'Date of expected return is required.',
                    'date_of_expected_return.date' => 'Please provide a valid date.',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed.',
                        'errors' => $validator->errors()
                    ], 422);
                }

                // Create child absent form
                $childAbsent = ChildAbsentForm::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'child_first_name' => $request->child_first_name,
                    'child_last_name' => $request->child_last_name,
                    'phone_number' => $request->phone_number,
                    'location' => $request->location,
                    'date_submission' => $request->date_submission,
                    'date_of_expected_return' => $request->date_of_expected_return,
                    'reason' => $request->reason,
                ]);

                // Send email notification
                try {
                    $formData = FormEmailHelper::formatFormData([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'child_first_name' => $request->child_first_name,
                        'child_last_name' => $request->child_last_name,
                        'phone_number' => $request->phone_number,
                        'location' => ucwords(str_replace('-', ' ', $request->location)),
                        'date_submission' => $request->date_submission,
                        'date_of_expected_return' => $request->date_of_expected_return,
                        'reason' => $request->reason,
                    ]);

                    GraphMailer::sendFormSubmission(FormEmailHelper::getAdminEmail(), 'child_absent_form', 'Child Absent Form Submitted', $formData);
                } catch (\Exception $e) {
                    Log::error('Failed to send child absent form email: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Child absent form submitted successfully!'
                ], 200);

            } catch (\Exception $e) {
                Log::error('Error submitting child absent form: ' . $e->getMessage(), [
                    'exception' => $e,
                    'request_data' => $request->all(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while submitting the form. Please try again.'
                ], 500);
            }
        }

        // Handle GET request - Display form
        return view('frontend.pages.forms.child_absent_form');
    }
}
