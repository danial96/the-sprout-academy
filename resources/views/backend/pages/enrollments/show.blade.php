@extends('backend.partials.master')

@section('title', 'Enrollment Details')

@section('content')
    <h1 class="mt-4">Enrollment Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.enrollments.index') }}">Enrollments</a></li>
        <li class="breadcrumb-item active">Enrollment #{{ $enrollment->id }}</li>
    </ol>

    <!-- Enrollment Info Card -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            Enrollment Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Enrollment ID:</strong> #{{ $enrollment->id }}</p>
                    <p><strong>Location:</strong> {{ strtoupper($enrollment->location) }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $enrollment->status === 'submitted' ? 'success' : 'warning' }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </p>
                    <p><strong>Current Step:</strong> {{ $enrollment->current_step }}/4</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Referrer:</strong> {{ $enrollment->referrer ? ucfirst(str_replace('-', ' ', $enrollment->referrer)) : 'N/A' }}</p>
                    <p><strong>Created At:</strong> {{ $enrollment->created_at->format('M d, Y h:i A') }}</p>
                    <p><strong>Updated At:</strong> {{ $enrollment->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    @php
        $primaryContact = $enrollment->contacts->where('is_primary', true)->first();
    @endphp

    <!-- Primary Contact Card -->
    @if($primaryContact)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user me-1"></i>
            Primary Account Person
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    @if($primaryContact->profile_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($primaryContact->profile_image) }}" 
                             alt="Profile" class="img-thumbnail" style="max-width: 150px;">
                    @else
                        <div class="bg-light p-5 text-center">No Image</div>
                    @endif
                </div>
                <div class="col-md-9">
                    <h5>{{ $primaryContact->first_name }} {{ $primaryContact->middle_initial ? $primaryContact->middle_initial . '.' : '' }} {{ $primaryContact->last_name }}</h5>
                    <p><strong>Gender:</strong> {{ ucfirst($primaryContact->gender ?? 'N/A') }}</p>
                    <p><strong>Date of Birth:</strong> {{ $primaryContact->date_of_birth ? $primaryContact->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Address Card -->
    @if($enrollment->addresses->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-map-marker-alt me-1"></i>
            Address Information
        </div>
        <div class="card-body">
            @foreach($enrollment->addresses as $address)
                <div class="mb-3">
                    <h6>
                        @if($address->is_physical && $address->is_mailing)
                            Physical & Mailing Address
                        @elseif($address->is_physical)
                            Physical Address
                        @elseif($address->is_mailing)
                            Mailing Address
                        @endif
                    </h6>
                    <p>
                        {{ $address->address_line_1 }}<br>
                        @if($address->address_line_2){{ $address->address_line_2 }}<br>@endif
                        {{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Phone Numbers Card -->
    @php
        $allPhones = collect();
        // Add enrollment phones
        if($enrollment->phones) {
            $allPhones = $allPhones->merge($enrollment->phones);
        }
        // Add contact phones
        foreach($enrollment->contacts as $contact) {
            if($contact->phones) {
                $allPhones = $allPhones->merge($contact->phones);
            }
        }
    @endphp
    @if($allPhones->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-phone me-1"></i>
            Phone Numbers
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Contact</th>
                            <th>Type</th>
                            <th>Area Code</th>
                            <th>Phone Number</th>
                            <th>Formatted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allPhones as $phone)
                            @php
                                $contact = $phone->contact ?? null;
                                $contactName = $contact ? $contact->first_name . ' ' . $contact->last_name : 'Primary Account';
                            @endphp
                            <tr>
                                <td>{{ $contactName }}</td>
                                <td>{{ ucfirst($phone->type ?? 'N/A') }}</td>
                                <td>{{ $phone->area_code ?? 'N/A' }}</td>
                                <td>{{ $phone->phone_number ?? 'N/A' }}</td>
                                <td>
                                    @if($phone->area_code && $phone->phone_number)
                                        ({{ $phone->area_code }}) {{ $phone->phone_number }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Children Card -->
    @if($enrollment->children->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-child me-1"></i>
            Children Information ({{ $enrollment->children->count() }})
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($enrollment->children as $child)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($child->profile_image)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($child->profile_image) }}" 
                                                 alt="Child" class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                            <div class="bg-light p-3 text-center">No Image</div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <h6>{{ $child->first_name }} {{ $child->middle_initial ? $child->middle_initial . '.' : '' }} {{ $child->last_name }}</h6>
                                        <p><strong>Gender:</strong> {{ ucfirst($child->gender ?? 'N/A') }}</p>
                                        <p><strong>Date of Birth:</strong> {{ $child->date_of_birth ? $child->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Emergency Contacts Card -->
    @php
        $emergencyContacts = $enrollment->contacts->where('is_primary', false);
    @endphp
    @if($emergencyContacts->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Emergency Contacts ({{ $emergencyContacts->count() }})
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($emergencyContacts as $contact)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if($contact->profile_image)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($contact->profile_image) }}" 
                                                 alt="Contact" class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                            <div class="bg-light p-3 text-center">No Image</div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <h6>{{ $contact->first_name }} {{ $contact->middle_initial ? $contact->middle_initial . '.' : '' }} {{ $contact->last_name }}</h6>
                                        <p><strong>Relationship Type:</strong> {{ ucfirst($contact->relationship_type ?? 'N/A') }}</p>
                                        <p><strong>Gender:</strong> {{ ucfirst($contact->gender ?? 'N/A') }}</p>
                                        <p><strong>Date of Birth:</strong> {{ $contact->date_of_birth ? $contact->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                                        <p>
                                            <span class="badge bg-{{ $contact->lives_with ? 'success' : 'secondary' }}">Lives With: {{ $contact->lives_with ? 'Yes' : 'No' }}</span>
                                            <span class="badge bg-{{ $contact->is_emergency_contact ? 'danger' : 'secondary' }}">Emergency: {{ $contact->is_emergency_contact ? 'Yes' : 'No' }}</span>
                                            <span class="badge bg-{{ $contact->is_authorized_pickup ? 'info' : 'secondary' }}">Pickup: {{ $contact->is_authorized_pickup ? 'Yes' : 'No' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
@endsection

