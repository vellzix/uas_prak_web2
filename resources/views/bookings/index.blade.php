@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">My Bookings</h1>
    </div>

    @if($bookings->isEmpty())
        <div class="alert alert-info">
            <h4 class="alert-heading">No bookings yet!</h4>
            <p class="mb-0">
                You haven't made any bookings yet. 
                <a href="{{ route('services.index') }}" class="alert-link">Browse our services</a> 
                to make your first booking.
            </p>
        </div>
    @else
        <div class="row">
            @foreach($bookings as $booking)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">{{ $booking->service->name }}</h5>
                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : 
                                                        ($booking->status === 'pending' ? 'warning' : 
                                                        ($booking->status === 'cancelled' ? 'danger' : 'secondary')) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <span class="badge bg-primary">
                                    {{ $booking->service->category->name }}
                                </span>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Check In</small>
                                    <strong>{{ $booking->check_in->format('M d, Y') }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Check Out</small>
                                    <strong>{{ $booking->check_out->format('M d, Y') }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Guests</small>
                                    <strong>{{ $booking->guests }}</strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Total Price</small>
                                    <strong>${{ number_format($booking->total_price, 2) }}</strong>
                                </div>
                            </div>

                            @if($booking->special_requests)
                                <div class="mb-3">
                                    <small class="text-muted d-block">Special Requests</small>
                                    <p class="mb-0">{{ $booking->special_requests }}</p>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Booking Code: {{ $booking->booking_code }}
                                </small>
                                <div>
                                    <a href="{{ route('bookings.show', $booking) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        View Details
                                    </a>
                                    @if($booking->isPending())
                                        <form action="{{ route('bookings.cancel', $booking) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection 