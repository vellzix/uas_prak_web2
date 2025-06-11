<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xl font-bold text-gray-800">Booking System</span>
            </div>

            <div class="flex items-center space-x-4">
            @if(Auth::check())
                
                <a href="{{ route('user.bookings') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-red-700 transition">
                    Lihat Pesanan Saya
                </a>
                <span class="text-gray-600 hidden md:inline">Halo, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Logout
                    </button>
                @else
                <p>Selamat datang, silakan <a href="{{ route('login') }}" class="text-blue-600">login</a></p>
                    @endif
                    @csrf
                </form>


            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 py-12">
    @if(Auth::check())
        <p class="text-gray-700 mb-6">
            Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Silakan jelajahi layanan yang tersedia di bawah ini.
        </p>

    @endif    

        @foreach($categories as $category)
            <div class="mb-10">
                <h2 class="text-2xl font-semibold text-indigo-700 mb-4">{{ $category->name }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($category->services as $service)
                        <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                            <p class="text-indigo-600 font-bold mt-2">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            <a href="{{ route('bookings.create', $service->id) }}"
                               class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                                Pesan Sekarang
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada layanan tersedia di kategori ini.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t text-center py-4 text-gray-500">
        &copy; 2025 Booking System. All rights reserved.
    </footer>
</body>
</html>
