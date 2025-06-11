<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Tampilkan daftar layanan.
     */
    public function index(Request $request)
    {
        $query = Service::with('category')->available();

        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $services = $query->paginate(12);
        $categories = Category::all();

        return view('services.index', compact('services', 'categories'));
    }
    

    /**
     * Tampilkan form untuk membuat layanan baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Simpan layanan baru ke dalam database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'capacity' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $validated['image'] = $path;
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }


    /**
     * Tampilkan detail layanan tertentu.
     */
    public function show(Service $service)
    {
        $service->load('category');
        $relatedServices = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->take(4)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }


    public function filter(Request $request)
    {
        $categoryId = $request->input('category');
        
        // Ambil semua kategori
        $categories = Category::all();
    
        // Ambil layanan sesuai kategori (atau semua jika tidak ada kategori dipilih)
        $services = $categoryId ? Service::where('category_id', $categoryId)->get() : Service::all();
    
        // Pastikan kita mengembalikan view 'home' dan meneruskan data layanan dan kategori
        return view('home', compact('services', 'categories'));
    }

    
    


    /**
     * Tampilkan form untuk mengedit layanan.
     */
    public function edit(Service $service)
    {
        $categories = Category::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Perbarui data layanan di database.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'capacity' => 'required|integer|min:1',
            'is_available' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $path = $request->file('image')->store('services', 'public');
            $validated['image'] = $path;
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Hapus layanan dari database.
     */
    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
