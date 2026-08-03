@extends('backend.partials.master')
@section('title', 'Standard T-Shirt Order Details')
@section('content')
    <h1 class="mt-4">Standard T-Shirt Order #{{ $order->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forms.standard-t-shirt-orders') }}">Standard T-Shirt Orders</a></li>
        <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-user me-1"></i> Customer Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
                    <p><strong>Location:</strong> {{ ucfirst(str_replace(['-','_'], ' ', $order->location ?? '')) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Submitted At:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-tshirt me-1"></i> Order Details</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Shirt Size:</strong> {{ strtoupper($order->shirt_size ?? 'N/A') }}</p>
                    <p><strong>Quantity:</strong> {{ $order->quantity ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Colors:</strong>
                        @if(is_array($order->colors))
                            {{ implode(', ', $order->colors) }}
                        @else
                            {{ $order->colors ?? 'N/A' }}
                        @endif
                    </p>
                </div>
            </div>
            @if($order->special_instructions)
            <hr>
            <p><strong>Special Instructions:</strong></p>
            <p style="white-space: pre-wrap;">{{ $order->special_instructions }}</p>
            @endif
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.forms.standard-t-shirt-orders') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>
@endsection
