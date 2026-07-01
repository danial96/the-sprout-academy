@extends('backend.partials.master')

@section('title', 'Locations')

@section('content')
    <h1 class="mt-4">Locations</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Locations</li>
    </ol>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Create New Location
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-map-marker-alt me-1"></i>
            Locations
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($locations as $location)
                        <tr>
                            <td>{{ $location->id }}</td>
                            <td>{{ $location->name }}</td>
                            <td><code>{{ $location->slug }}</code></td>
                            <td>{{ Str::limit($location->address, 40) }}</td>
                            <td>{{ $location->phone ?? 'N/A' }}</td>
                            <td>{{ $location->display_order }}</td>
                            <td>
                                @if ($location->is_active)
                                    <span class="badge bg-success" id="status-{{ $location->id }}">Active</span>
                                @else
                                    <span class="badge bg-danger" id="status-{{ $location->id }}">Restricted</span>
                                @endif
                            </td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('admin.locations.edit', $location->id) }}"
                                   class="btn btn-sm btn-primary"
                                   title="Edit"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="toggleLocation({{ $location->id }}, this)"
                                        class="btn btn-sm {{ $location->is_active ? 'btn-success' : 'btn-warning' }}"
                                        title="{{ $location->is_active ? 'Restrict Location' : 'Restricted' }}"
                                        data-bs-toggle="tooltip"
                                        data-active="{{ $location->is_active ? '1' : '0' }}">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <form action="{{ route('admin.locations.destroy', $location->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this location?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete" data-bs-toggle="tooltip">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No locations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el, { trigger: 'hover' });
    });

    function toggleLocation(id, btn) {
        const isActive = btn.dataset.active === '1';
        const action = isActive ? 'restrict' : 'activate';
        if (!confirm(`Are you sure you want to ${action} this location?`)) return;

        fetch(`/admin/locations/${id}/toggle-active`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            const nowActive = data.is_active;
            btn.dataset.active = nowActive ? '1' : '0';
            btn.className = `btn btn-sm ${nowActive ? 'btn-success' : 'btn-warning'}`;

            const tooltip = bootstrap.Tooltip.getInstance(btn);
            if (tooltip) tooltip.dispose();
            btn.setAttribute('title', nowActive ? 'Restrict Location' : 'Restricted');
            new bootstrap.Tooltip(btn, { trigger: 'hover' });

            const badge = document.getElementById(`status-${id}`);
            badge.className = `badge ${nowActive ? 'bg-success' : 'bg-danger'}`;
            badge.textContent = nowActive ? 'Active' : 'Restricted';
        });
    }
</script>
@endpush

