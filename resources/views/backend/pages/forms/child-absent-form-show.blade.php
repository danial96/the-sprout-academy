@extends('backend.partials.master')
@section('title', 'Child Absent Form Details')
@section('content')
    <h1 class="mt-4">Child Absent Form #{{ $form->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forms.child-absent-forms') }}">Child Absent Forms</a></li>
        <li class="breadcrumb-item active">Form #{{ $form->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-user me-1"></i> Parent / Guardian Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $form->first_name }} {{ $form->last_name }}</p>
                    <p><strong>Phone:</strong> {{ $form->phone_number ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Location:</strong> {{ ucfirst(str_replace(['-','_'], ' ', $form->location ?? '')) }}</p>
                    <p><strong>Submitted At:</strong> {{ $form->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-child me-1"></i> Child Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Child Name:</strong> {{ $form->child_first_name ?? '' }} {{ $form->child_last_name ?? '' }}</p>
                    <p><strong>Date of Submission:</strong> {{ $form->date_submission ? $form->date_submission->format('M d, Y') : 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Expected Return Date:</strong> {{ $form->date_of_expected_return ? $form->date_of_expected_return->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($form->reason)
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-align-left me-1"></i> Reason for Absence</div>
        <div class="card-body">
            <p style="white-space: pre-wrap;">{{ $form->reason }}</p>
        </div>
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.forms.child-absent-forms') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>
@endsection
