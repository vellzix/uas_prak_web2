@extends('layouts.app')

@section('title', $service->name)

@section('content')
<div class="bg-[#FF6B6B] py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center text-white mb-4">
            <a href="{{ route('services.index') }}" class="text-[#ffe6e6] hover:text-white">
                <i class="fas fa-arrow-left mr-2"></i> Back to Services
            </a>
        </div>
        <h1 class="text-4xl font-bold text-white mb-2">{{ $service->name }}</h1>
        <div class="flex items-center text-[#ffe6e6]">
            <span class="flex items-center">
                <i class="fas fa-tag mr-2"></i>
                {{ $service->category->name }}
            </span>
            <span class="mx-4">|</span>
            <span class="flex items-center">
                <i class="fas fa-user mr-2"></i>
                {{ $service->capacity }} {{ Str::plural('guest', $service->capacity) }}
            </span>
            <span class="mx-4">|</span>
            <span class="flex items-center">
                <i class="fas fa-dollar-sign mr-2"></i>
                ${{ number_format($service->price, 2) }} per person
            </span>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Service Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://source.unsplash.com/1200x600/?{{ urlencode($service->category->name) }}" 
                     alt="{{ $service->name }}" 
                     class="w-full h-96 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">About This Service</h2>
                    <p class="text-gray-600 mb-6">{{ $service->description }}</p>

                    <h3 class="text-xl font-semibold mb-4">Highlights</h3>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-[#fff3f3] flex items-center justify-center">
                                <i class="fas fa-clock text-[#FF6B6B]"></i>
                            </div>
                            <span class="ml-3 text-gray-600">Flexible scheduling</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-[#fff3f3] flex items-center justify-center">
                                <i class="fas fa-shield-alt text-[#FF6B6B]"></i>
                            </div>
                            <span class="ml-3 text-gray-600">Secure booking</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-[#fff3f3] flex items-center justify-center">
                                <i class="fas fa-user-check text-[#FF6B6B]"></i>
                            </div>
                            <span class="ml-3 text-gray-600">Professional service</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-[#fff3f3] flex items-center justify-center">
                                <i class="fas fa-heart text-[#FF6B6B]"></i>
                            </div>
                            <span class="ml-3 text-gray-600">Satisfaction guaranteed</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-4">Location</h3>
                    <div class="bg-gray-100 rounded-lg p-4 mb-6">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt text-[#FF6B6B] mr-2"></i>
                            Location details will be provided after booking
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-4">Cancellation Policy</h3>
                    <p class="text-gray-600">
                        Free cancellation up to 24 hours before the start of your booking. 
                        Please read our <a href="#" class="text-[#4ECDC4] hover:text-[#45b8b0]">full policy</a> for more details.
                    </p>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                <h3 class="text-2xl font-bold mb-6">Book This Service</h3>
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Date</label>
                        <input type="date" 
                               name="booking_date" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#4ECDC4] focus:border-[#4ECDC4]"
                               min="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Number of Guests</label>
                        <select name="number_of_people" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#4ECDC4] focus:border-[#4ECDC4]"
                                required>
                            @for($i = 1; $i <= $service->capacity; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ Str::plural('Person', $i) }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Special Requests</label>
                        <textarea name="notes" 
                                  rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#4ECDC4] focus:border-[#4ECDC4]"
                                  placeholder="Any special requirements or requests?"></textarea>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Price per person</span>
                            <span class="font-semibold">${{ number_format($service->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total</span>
                            <span class="text-[#FF6B6B]">$<span id="total-price">{{ number_format($service->price, 2) }}</span></span>
                        </div>
                    </div>

                    @auth
                        <button type="submit" class="w-full bg-[#4ECDC4] text-white py-3 rounded-lg font-semibold hover:bg-[#45b8b0] transition">
                            Book Now
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-[#4ECDC4] text-white py-3 rounded-lg font-semibold hover:bg-[#45b8b0] transition text-center">
                            Login to Book
                        </a>
                    @endauth
                </form>
            </div>
        </div>
    </div>

    <!-- Similar Services -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Similar Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($service->category->services()->where('id', '!=', $service->id)->limit(3)->get() as $similarService)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden card">
                    <img src="https://source.unsplash.com/800x600/?{{ urlencode($similarService->category->name) }}" 
                         alt="{{ $similarService->name }}" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-3 py-1 bg-[#fff3f3] text-[#FF6B6B] rounded-full text-sm">
                                {{ $similarService->category->name }}
                            </span>
                            <span class="text-gray-600">
                                <i class="fas fa-user mr-1"></i> 
                                {{ $similarService->capacity }} {{ Str::plural('guest', $similarService->capacity) }}
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">{{ $similarService->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($similarService->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-[#FF6B6B]">${{ number_format($similarService->price, 2) }}</span>
                            <a href="{{ route('services.show', $similarService) }}" 
                               class="inline-flex items-center text-[#4ECDC4] hover:text-[#45b8b0]">
                                View Details <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pricePerPerson = {{ $service->price }};
    const guestSelect = document.querySelector('select[name="number_of_people"]');
    const totalPriceElement = document.getElementById('total-price');

    function updateTotalPrice() {
        const numberOfGuests = parseInt(guestSelect.value);
        const totalPrice = (pricePerPerson * numberOfGuests).toFixed(2);
        totalPriceElement.textContent = totalPrice;
    }

    guestSelect.addEventListener('change', updateTotalPrice);
});
</script>
@endpush
@endsection 