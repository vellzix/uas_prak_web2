<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with(['service.category'])
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function adminIndex(Request $request)
    {
        $query = Booking::with(['user', 'service.category'])->latest();

        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('booking_code', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $bookings = $query->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create(Service $service)
    {
        return view('bookings.create', compact('service'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string'
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        if (!$service->isAvailable()) {
            return back()->with('error', 'Sorry, this service is not available at the moment.');
        }

        if ($validated['guests'] > $service->capacity) {
            return back()->with('error', 'Number of guests exceeds service capacity.');
        }

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $days = $checkIn->diffInDays($checkOut);
        $totalPrice = $service->price * $days;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'total_price' => $totalPrice,
            'special_requests' => $validated['special_requests'],
            'booking_code' => 'BK-' . Str::random(8),
            'status' => 'pending'
        ]);

        // You might want to send notification here
        
        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully. Your booking code is: ' . $booking->booking_code);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['service.category', 'user']);
        
        return view('bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed'
        ]);

        switch ($validated['status']) {
            case 'confirmed':
                $booking->confirm();
                break;
            case 'cancelled':
                $booking->cancel();
                break;
            case 'completed':
                $booking->complete();
                break;
        }

        // You might want to send notification here

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        if (!$booking->isPending()) {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }

        $booking->cancel();

        // You might want to send notification here

        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function myBookings()
    {
        $bookings = \App\Models\Booking::with('service')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.my-bookings', compact('bookings'));
    }

    public function destroy(Booking $booking)
    {
        if (auth()->id() !== $booking->user_id) {
            abort(403, 'Akses ditolak');
        }

        $booking->delete();

        return redirect()->route('user.bookings')->with('success', 'Pesanan berhasil dihapus.');
    }
}
