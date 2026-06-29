@extends('backend.partials.master')

@section('title', 'Standard T-Shirt Orders')

@section('content')
    <h1 class="mt-4">Standard T-Shirt Orders</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Standard T-Shirt Orders</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tshirt me-1"></i>
            Standard T-Shirt Orders
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Size</th>
                        <th>Colors</th>
                        <th>Special Instructions</th>
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
                ajax: "{{ route('admin.forms.standard-t-shirt-orders') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'location', name: 'location' },
                    { data: 'size', name: 'size' },
                    { data: 'colors', name: 'colors' },
                    { data: 'special_instructions', name: 'special_instructions' },
                    { data: 'created_at', name: 'created_at' }
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endpush
