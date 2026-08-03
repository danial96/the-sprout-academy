@extends('backend.partials.master')
@section('title', 'Time Off Request Details')
@section('content')
    <h1 class="mt-4">Time Off Request #{{ $record->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forms.time-off-requests') }}">Time Off Requests</a></li>
        <li class="breadcrumb-item active">Request #{{ $record->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-user me-1"></i> Employee Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $record->name }}</p>
                    <p><strong>Email:</strong> {{ $record->email ?? 'N/A' }}</p>
                    <p><strong>Location:</strong> {{ ucfirst(str_replace(['-','_'], ' ', $record->location ?? '')) }}</p>
                    <p><strong>Status:</strong>
                        @php $badgeClass = $record->status === 'approved' ? 'success' : ($record->status === 'rejected' ? 'danger' : 'warning'); @endphp
                        <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($record->status) }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Today's Date:</strong> {{ $record->todays_date ? $record->todays_date->format('M d, Y') : 'N/A' }}</p>
                    <p><strong>Start Date:</strong> {{ $record->start_date ? $record->start_date->format('M d, Y') : 'N/A' }}</p>
                    <p><strong>End Date:</strong> {{ $record->end_date ? $record->end_date->format('M d, Y') : 'N/A' }}</p>
                    <p><strong>Paid / Unpaid:</strong> {{ ucfirst($record->paid_unpaid ?? 'N/A') }}</p>
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

    @if($record->rejection_reason)
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-times-circle me-1"></i> Rejection Reason</div>
        <div class="card-body">
            <p style="white-space: pre-wrap;">{{ $record->rejection_reason }}</p>
        </div>
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.forms.time-off-requests') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>
@endsection
