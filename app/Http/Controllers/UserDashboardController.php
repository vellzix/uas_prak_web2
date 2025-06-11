<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class UserDashboardController extends Controller
{
    public function index()
    {
        $categories = Category::with('services')->get();
        return view('user.dashboard', compact('categories'));
    }
}
