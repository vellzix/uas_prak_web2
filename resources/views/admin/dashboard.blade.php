@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Users</h6>
                    <h2 class="card-title mb-0">{{ $stats['total_users'] }}</h2>
                    <div class="mt-2">
                        <small class="text-success">
                            <i class="bi bi-people-fill"></i> Active Users
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Services</h6>
                    <h2 class="card-title mb-0">{{ $stats['total_services'] }}</h2>
                    <div class="mt-2">
                        <small class="text-primary">
                            <i class="bi bi-box-seam"></i> Available Services
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Bookings</h6>
                    <h2 class="card-title mb-0">{{ $stats['total_bookings'] }}</h2>
                    <div class="mt-2">
                        <small class="text-warning">
                            <i class="bi bi-calendar-check"></i> All Time
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Pending Bookings</h6>
                    <h2 class="card-title mb-0">{{ $stats['pending_bookings'] }}</h2>
                    <div class="mt-2">
                        <small class="text-danger">
                            <i class="bi bi-clock-history"></i> Need Attention
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Monthly Bookings Chart -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Monthly Bookings</h5>
                    <canvas id="monthlyBookingsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Recent Bookings</h5>
                    <div class="list-group list-group-flush">
                        @foreach($recentBookings as $booking)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $booking->user->name }}</h6>
                                        <p class="mb-1 text-muted small">
                                            {{ $booking->service->name }}
                                        </p>
                                        <small class="text-muted">
                                            {{ $booking->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 
                                                            ($booking->status === 'pending' ? 'warning' : 
                                                            ($booking->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary btn-sm w-100">
                            View All Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyBookingsChart').getContext('2d');
    const monthlyData = @json($monthlyBookings);
    const labels = Array.from({length: 12}, (_, i) => {
        const date = new Date(2024, i, 1);
        return date.toLocaleString('default', { month: 'short' });
    });
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of Bookings',
                data: labels.map((_, index) => monthlyData[index + 1] || 0),
                borderColor: 'rgb(13, 110, 253)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush 