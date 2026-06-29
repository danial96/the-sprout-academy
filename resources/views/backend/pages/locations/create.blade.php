@extends('backend.partials.master')

@section('title', 'Create Location')

@section('content')
    <h1 class="mt-4">Create Location</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.locations.index') }}">Locations</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            New Location
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.locations.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
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
                        class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="fax" class="form-label">Fax</label>
                            <input type="text" id="fax" name="fax"
                                class="form-control @error('fax') is-invalid @enderror" value="{{ old('fax') }}">
                            @error('fax')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="hours_of_operation" class="form-label">Hours of Operation</label>
                    <textarea id="hours_of_operation" name="hours_of_operation" rows="2"
                        class="form-control @error('hours_of_operation') is-invalid @enderror">{{ old('hours_of_operation') }}</textarea>
                    @error('hours_of_operation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="google_maps_address" class="form-label">Google Maps Address <span class="text-danger">*</span></label>
                    <textarea id="google_maps_address" name="google_maps_address" rows="2"
                        class="form-control @error('google_maps_address') is-invalid @enderror" required>{{ old('google_maps_address') }}</textarea>
                    @error('google_maps_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Address to be used for Google Maps embed</div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="virtual_tour_image" class="form-label">Virtual Tour Image</label>
                            <input type="file" id="virtual_tour_image" name="virtual_tour_image"
                                class="form-control @error('virtual_tour_image') is-invalid @enderror" accept="image/*">
                            @error('virtual_tour_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Image for virtual tour page (max 2MB)</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="virtual_tour_label" class="form-label">Virtual Tour Label</label>
                            <input type="text" id="virtual_tour_label" name="virtual_tour_label"
                                class="form-control @error('virtual_tour_label') is-invalid @enderror" value="{{ old('virtual_tour_label') }}" placeholder="e.g., FRONT OFFICE">
                            @error('virtual_tour_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="home_page_image" class="form-label">Home Page Image</label>
                    <input type="file" id="home_page_image" name="home_page_image"
                        class="form-control @error('home_page_image') is-invalid @enderror" accept="image/*">
                    @error('home_page_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Image for home page location card (max 2MB)</div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" id="display_order" name="display_order" min="0"
                                class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', 0) }}">
                            @error('display_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lower numbers appear first</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            <div class="form-text">Uncheck to hide this location from frontend</div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Location</button>
                <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

