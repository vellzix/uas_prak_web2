<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('home'); // dashboard admin tetap di home.blade.php
    }

    public function userDashboard()
    {
        return view('user.dashboard');
    }
}
