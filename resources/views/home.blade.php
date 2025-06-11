<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xl font-bold text-gray-800">Booking System - Admin</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 hidden md:inline">Halo, {{ Auth::user()->name ?? 'Admin' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard Admin</h1>

        <!-- Menu Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <a href="{{ route('services.create') }}"
               class="block bg-white p-6 rounded-xl shadow hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-indigo-600">Tambah Layanan</h2>
                <p class="text-gray-600 mt-2">Buat layanan baru untuk pengguna pesan.</p>
            </a>

            <a href="{{ route('categories.index') }}"
               class="block bg-white p-6 rounded-xl shadow hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-indigo-600">Kelola Kategori</h2>
                <p class="text-gray-600 mt-2">Lihat dan kelola kategori layanan yang tersedia.</p>
            </a>

            <a href="{{ route('admin.createUser') }}"
               class="block bg-white p-6 rounded-xl shadow hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-indigo-600">Tambah Admin</h2>
                <p class="text-gray-600 mt-2">Buat akun baru dengan peran admin.</p>
            </a>
        </div>

        <!-- Daftar Layanan -->
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Layanan Tersedia</h2>

            @if ($services->isEmpty())
                <p class="text-gray-500">Belum ada layanan yang tersedia.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition relative">
                            <h3 class="text-lg font-semibold text-indigo-600">{{ $service->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $service->description }}</p>
                            <p class="text-sm text-gray-500 mt-2">Kategori: {{ $service->category->name }}</p>
                            <p class="text-indigo-600 font-bold mt-2">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                            
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus layanan ini?')"
                                        class="px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t text-center py-4 text-gray-500">
        &copy; {{ date('Y') }} Booking System. All rights reserved.
    </footer>

</body>
</html>
