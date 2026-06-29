<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminEnrollmentController extends Controller
{
    /**
     * Get available locations for filter dropdown
     */
    public function getLocations()
    {
        $locations = Enrollment::select('location')
            ->distinct()
            ->whereNotNull('location')
            ->orderBy('location')
            ->pluck('location')
            ->map(function ($location) {
                return [
                    'value' => $location,
                    'label' => strtoupper(str_replace('-', ' ', $location))
                ];
            })
            ->values();

        return response()->json($locations);
    }

    /**
     * Display list of all enrollments
     */
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $enrollments = Enrollment::with([
                'contacts' => function ($query) {
                    $query->where('is_primary', true);
                },
                'children'
            ])->select('enrollments.*');

            // Apply location filter if provided
            if ($request->has('location') && $request->location !== '' && $request->location !== 'all') {
                $enrollments->where('location', $request->location);
            }

            return DataTables::of($enrollments)
                ->addColumn('primary_contact', function ($enrollment) {
                    $primaryContact = $enrollment->contacts->where('is_primary', true)->first();
                    if ($primaryContact) {
                        return $primaryContact->first_name . ' ' . $primaryContact->last_name;
                    }
                    return 'N/A';
                })
                ->addColumn('children_count', function ($enrollment) {
                    return $enrollment->children->count();
                })
                ->editColumn('location', function ($enrollment) {
                    return strtoupper(str_replace('-', ' ', $enrollment->location));
                })
                ->editColumn('status', function ($enrollment) {
                    $badgeClass = $enrollment->status === 'submitted' ? 'success' : 'warning';
                    return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($enrollment->status) . '</span>';
                })
                ->editColumn('referrer', function ($enrollment) {
                    return $enrollment->referrer ? ucfirst(str_replace('-', ' ', $enrollment->referrer)) : 'N/A';
                })
                ->editColumn('created_at', function ($enrollment) {
                    return $enrollment->created_at->format('M d, Y h:i A');
                })
                ->addColumn('action', function ($enrollment) {
                    return '<a href="' . route('admin.enrollments.show', $enrollment->id) . '" class="btn btn-sm btn-primary">
                        <i class="fas fa-eye"></i> View Details
                    </a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.pages.enrollments.index');
    }

    /**
     * Display enrollment details
     */
    public function show($id)
    {
        $enrollment = Enrollment::with([
            'contacts' => function ($query) {
                $query->orderBy('is_primary', 'desc');
            },
            'contacts.phones',
            'children',
            'addresses',
            'phones'
        ])->findOrFail($id);

        return view('backend.pages.enrollments.show', compact('enrollment'));
    }
}

