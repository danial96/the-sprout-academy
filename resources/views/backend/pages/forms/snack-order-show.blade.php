@extends('backend.partials.master')
@section('title', 'Snack Order Details')
@section('content')
    <h1 class="mt-4">Snack Order #{{ $order->id }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forms.snack-orders') }}">Snack Orders</a></li>
        <li class="breadcrumb-item active">Order #{{ $order->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-info-circle me-1"></i> Order Information</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Location:</strong> {{ ucfirst(str_replace(['-','_'], ' ', $order->location)) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Submitted At:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-apple-alt me-1"></i> Order Items</div>
        <div class="card-body">
            @if(is_array($order->order_items) && count($order->order_items))
                <table class="table table-bordered table-striped">
                    <thead><tr><th>Item</th><th>Quantity</th></tr></thead>
                    <tbody>
                        @foreach($order->order_items as $key => $qty)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                <td>{{ $qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No items ordered.</p>
            @endif
        </div>
    </div>

    @if($order->other)
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-align-left me-1"></i> Other Notes</div>
        <div class="card-body">
            <p style="white-space: pre-wrap;">{{ $order->other }}</p>
        </div>
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.forms.snack-orders') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>
@endsection
