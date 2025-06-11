<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('services')->get();
        $featuredServices = Service::with('category')
            ->available()
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('home', compact('categories', 'featuredServices'));
    }
}

