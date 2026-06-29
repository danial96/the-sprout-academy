@extends('backend.partials.master')

@section('title', 'Edit Location')

@section('content')
    <h1 class="mt-4">Edit Location</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.locations.index') }}">Locations</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Location
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.locations.update', $location->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $location->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $location->slug) }}" required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">URL-friendly identifier (e.g., "seminole", "pinellas-park")</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <textarea id="address" name="address" rows="2"
                        class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $location->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $location->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="fax" class="form-label">Fax</label>
                            <input type="text" id="fax" name="fax"
                                class="form-control @error('fax') is-invalid @enderror" value="{{ old('fax', $location->fax) }}">
                            @error('fax')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $location->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="hours_of_operation" class="form-label">Hours of Operation</label>
                    <textarea id="hours_of_operation" name="hours_of_operation" rows="2"
                        class="form-control @error('hours_of_operation') is-invalid @enderror">{{ old('hours_of_operation', $location->hours_of_operation) }}</textarea>
                    @error('hours_of_operation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="google_maps_address" class="form-label">Google Maps Address <span class="text-danger">*</span></label>
                    <textarea id="google_maps_address" name="google_maps_address" rows="2"
                        class="form-control @error('google_maps_address') is-invalid @enderror" required oninput="updateMapPreview()">{{ old('google_maps_address', $location->google_maps_address) }}</textarea>
                    @error('google_maps_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Address to be used for Google Maps embed</div>
                    
                    {{-- Google Maps Preview --}}
                    <div class="mt-3" id="mapPreview" style="height: 300px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                        @php
                            $encodedAddress = urlencode($location->google_maps_address ?? '');
                        @endphp
                        <iframe
                            id="mapIframe"
                            src="https://www.google.com/maps?q={{ $encodedAddress }}&output=embed&z=15"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Google Maps Preview">
                        </iframe>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $location->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <div class="form-text">Uncheck to hide this location from frontend</div>
                </div>

                <button type="submit" class="btn btn-primary">Update Location</button>
                <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateMapPreview() {
                const addressInput = document.getElementById('google_maps_address');
                const mapIframe = document.getElementById('mapIframe');
                
                if (addressInput && mapIframe) {
                    const address = encodeURIComponent(addressInput.value);
                    if (address) {
                        mapIframe.src = `https://www.google.com/maps?q=${address}&output=embed&z=15`;
                    }
                }
            }
        </script>
    @endpush
@endsection

