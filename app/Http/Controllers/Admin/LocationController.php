<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::orderBy('display_order')->orderBy('name')->get();
        return view('backend.pages.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:locations,slug'],
            'address' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'fax' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'hours_of_operation' => ['nullable', 'string'],
            'google_maps_address' => ['required', 'string'],
            'virtual_tour_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'virtual_tour_label' => ['nullable', 'string', 'max:255'],
            'home_page_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Handle image uploads
        if ($request->hasFile('virtual_tour_image')) {
            $file = $request->file('virtual_tour_image');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $data['virtual_tour_image'] = $file->storeAs('locations/virtual-tour', $filename, 'public');
        }

        if ($request->hasFile('home_page_image')) {
            $file = $request->file('home_page_image');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $data['home_page_image'] = $file->storeAs('locations/home-page', $filename, 'public');
        }

        $data['is_active'] = $request->has('is_active') ? true : false;
        $data['display_order'] = $data['display_order'] ?? 0;

        Location::create($data);

        return redirect()
            ->route('admin.locations.index')
            ->with('status', 'Location created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('backend.pages.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:locations,slug,' . $id],
            'address' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'fax' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'hours_of_operation' => ['nullable', 'string'],
            'google_maps_address' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->has('is_active') ? true : false;

        $location->update($data);

        return redirect()
            ->route('admin.locations.index')
            ->with('status', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        // Delete associated images
        if ($location->virtual_tour_image) {
            Storage::disk('public')->delete($location->virtual_tour_image);
        }
        if ($location->home_page_image) {
            Storage::disk('public')->delete($location->home_page_image);
        }

        $location->delete();

        return redirect()
            ->route('admin.locations.index')
            ->with('status', 'Location deleted successfully.');
    }
}
