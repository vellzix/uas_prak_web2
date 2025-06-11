@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div class="bg-[#FF6B6B] py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-white text-center mb-4">Explore Our Services</h1>
        <p class="text-xl text-[#ffe6e6] text-center">Find and book the perfect service for your next adventure</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <form action="{{ route('services.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Category</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#4ECDC4] focus:border-[#4ECDC4]">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Price Range</label>
                <select name="price" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#4ECDC4] focus:border-[#4ECDC4]">
                    <option value="">Any Price</option>
                    <option value="0-100" {{ request('price') == '0-100' ? 'selected' : '' }}>$0 - $100</option>
                    <option value="100-500" {{ request('price') == '100-500' ? 'selected' : '' }}>$100 - $500</option>
                    <option value="500-1000" {{ request('price') == '500-1000' ? 'selected' : '' }}>$500 - $1000</option>
                    <option value="1000+" {{ request('price') == '1000+' ? 'selected' : '' }}>$1000+</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Capacity</label>
                <select name="capacity" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#4ECDC4] focus:border-[#4ECDC4]">
                    <option value="">Any Size</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>
                            {{ $i }} {{ Str::plural('Person', $i) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-[#4ECDC4] text-white px-6 py-2 rounded-lg hover:bg-[#45b8b0] transition">
                    <i class="fas fa-filter mr-2"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($services as $service)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden card">
                <img src="https://source.unsplash.com/800x600/?{{ urlencode($service->category->name) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-3 py-1 bg-[#fff3f3] text-[#FF6B6B] rounded-full text-sm">{{ $service->category->name }}</span>
                        <span class="text-gray-600">
                            <i class="fas fa-user mr-1"></i> {{ $service->capacity }} {{ Str::plural('guest', $service->capacity) }}
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ $service->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-2xl font-bold text-[#FF6B6B]">${{ number_format($service->price, 2) }}</span>
                            <span class="text-gray-500 text-sm">/person</span>
                        </div>
                        <a href="{{ route('services.show', $service) }}" 
                           class="inline-flex items-center px-4 py-2 bg-[#4ECDC4] text-white rounded-lg hover:bg-[#45b8b0] transition">
                            Book Now <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <div class="bg-gray-50 rounded-lg p-8">
                    <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Services Found</h3>
                    <p class="text-gray-600">Try adjusting your search criteria or browse all services.</p>
                    <a href="{{ route('services.index') }}" class="inline-block mt-4 text-[#4ECDC4] hover:text-[#45b8b0]">
                        Clear all filters <i class="fas fa-redo ml-1"></i>
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $services->links() }}
    </div>
</div>
@endsection
