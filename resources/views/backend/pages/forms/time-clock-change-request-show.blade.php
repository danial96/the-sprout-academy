@extends('backend.partials.master')
@section('title', 'Time Clock Change Request Details')
@section('content')
    <h1 class="mt-4">Time Clock Change Request #{{ $record->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forms.time-clock-change-requests') }}">Time Clock Change Requests</a></li>
        <li class="breadcrumb-item active">Request #{{ $record->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-user me-1"></i> Employee Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $record->first_name }} {{ $record->last_name }}</p>
                    <p><strong>Location:</strong> {{ ucfirst(str_replace(['-','_'], ' ', $record->location ?? '')) }}</p>
                    <p><strong>Date to be Changed:</strong> {{ $record->date_to_be_changed ? $record->date_to_be_changed->format('M d, Y') : 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Clock In:</strong> {{ $record->clock_in ?? 'N/A' }}</p>
                    <p><strong>Clock Out:</strong> {{ $record->clock_out ?? 'N/A' }}</p>
                    <p><strong>Submitted At:</strong> {{ $record->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($record->reason)
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-align-left me-1"></i> Reason</div>
        <div class="card-body">
            <p style="white-space: pre-wrap;">{{ $record->reason }}</p>
        </div>
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.forms.time-clock-change-requests') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>
@endsection
