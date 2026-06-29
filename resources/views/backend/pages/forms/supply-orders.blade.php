@extends('backend.partials.master')

@section('title', 'Supply Orders')

@section('content')
    <h1 class="mt-4">Supply Orders</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Supply Orders</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-box me-1"></i>
            Supply Orders
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location</th>
                        <th>Items Count</th>
                        <th>Order Items</th>
                        <th>Other</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this -->
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.forms.supply-orders') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'location', name: 'location' },
                    { data: 'items_count', name: 'items_count' },
                    { data: 'order_items', name: 'order_items' },
                    { data: 'other', name: 'other' },
                    { data: 'created_at', name: 'created_at' }
                ],
                order: [[0, 'desc']]
            });
        });
    </script>
@endpush

