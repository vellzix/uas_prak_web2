<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', '!=', 'admin')->count(),
            'total_services' => Service::count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
        ];

        $recentBookings = Booking::with(['user', 'service'])
            ->latest()
            ->take(5)
            ->get();

        $monthlyBookings = Booking::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'monthlyBookings'));
    }
} 