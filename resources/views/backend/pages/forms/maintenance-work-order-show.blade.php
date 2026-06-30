@extends('backend.partials.master')

@section('title', 'Maintenance Work Order Details')

@section('content')
    <h1 class="mt-4">Maintenance Work Order #{{ $order->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forms.maintenance-work-orders') }}">Maintenance Work Orders</a></li>
        <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-wrench me-1"></i>
            Order Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
                    <p><strong>Location:</strong> {{ ucfirst($order->location) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Area of Repair:</strong> {{ ucfirst($order->area_repair) }}</p>
                    <p><strong>Today's Date:</strong> {{ $order->todays_date ? $order->todays_date->format('M d, Y') : 'N/A' }}</p>
                    <p><strong>Completion Date:</strong> {{ $order->completion_date ? $order->completion_date->format('M d, Y') : 'N/A' }}</p>
                    <p><strong>Submitted At:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($order->description)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-align-left me-1"></i>
            Description
        </div>
        <div class="card-body">
            <p style="white-space: pre-wrap;">{{ $order->description }}</p>
        </div>
    </div>
    @endif

    @if($order->file_path)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-paperclip me-1"></i>
            Attachment
        </div>
        <div class="card-body">
            @php
                $ext = strtolower(pathinfo($order->file_path, PATHINFO_EXTENSION));
                $imageExts = ['jpg','jpeg','png','gif','webp'];
                $fileUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($order->file_path);
            @endphp
            @if(in_array($ext, $imageExts))
                <img src="{{ $fileUrl }}" alt="Attachment" class="img-fluid" style="max-width:600px;">
            @else
                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary">
                    <i class="fas fa-download me-1"></i> Download Attachment
                </a>
            @endif
        </div>
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.forms.maintenance-work-orders') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
@endsection
