@extends('backend.partials.master')
@section('title', 'Employment Application Details')
@section('content')
    <h1 class="mt-4">Employment Application #{{ $application->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forms.employment-applications') }}">Employment Applications</a></li>
        <li class="breadcrumb-item active">Application #{{ $application->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-user me-1"></i> Applicant Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $application->first_name }} {{ $application->last_name }}</p>
                    <p><strong>Email:</strong> {{ $application->email }}</p>
                    <p><strong>Phone:</strong> {{ $application->phone }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Submitted At:</strong> {{ $application->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-briefcase me-1"></i> Job Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Position:</strong> {{ ucwords(str_replace('_', ' ', $application->position)) }}</p>
                    <p><strong>Location:</strong> {{ ucwords(str_replace('_', ' ', $application->location)) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Desired Start Date:</strong> {{ $application->start_date ? \Carbon\Carbon::parse($application->start_date)->format('M d, Y') : 'N/A' }}</p>
                    <p><strong>Desired Salary:</strong> ${{ $application->salary_dollars ?? '0' }}.{{ $application->salary_cents ?? '00' }}/hr</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-paperclip me-1"></i> Resume</div>
        <div class="card-body">
            @if($application->resume_path)
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.forms.employment-applications.resume', ['id' => $application->id, 'action' => 'download']) }}" class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Download Resume
                    </a>
                    <a href="{{ route('admin.forms.employment-applications.resume', ['id' => $application->id, 'action' => 'view']) }}" target="_blank" class="btn btn-secondary">
                        <i class="fas fa-eye me-1"></i> View Resume
                    </a>
                </div>
            @else
                <p class="text-muted">No resume uploaded.</p>
            @endif
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.forms.employment-applications') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>
@endsection
