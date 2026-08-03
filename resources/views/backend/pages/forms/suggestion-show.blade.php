@extends('backend.partials.master')
@section('title', 'Suggestion Details')
@section('content')
    <h1 class="mt-4">Suggestion #{{ $suggestion->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forms.suggestions') }}">Suggestions</a></li>
        <li class="breadcrumb-item active">Suggestion #{{ $suggestion->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-user me-1"></i> Submitted By</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $suggestion->first_name }} {{ $suggestion->last_name }}</p>
                    <p><strong>Location:</strong> {{ ucfirst(str_replace(['-','_'], ' ', $suggestion->location)) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Submitted At:</strong> {{ $suggestion->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-lightbulb me-1"></i> Suggestion</div>
        <div class="card-body">
            <p style="white-space: pre-wrap;">{{ $suggestion->suggestion }}</p>
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.forms.suggestions') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>
@endsection
