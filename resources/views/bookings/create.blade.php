<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="max-w-3xl w-full bg-white shadow-lg rounded-lg p-8 mt-10 mb-10">
        
        <!-- Tombol Kembali -->
        <div class="mb-4">
            <a href="{{ route('services.index') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded">
                ← Kembali
            </a>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            Pemesanan : <span class="text-blue-600">{{ $service->name }}</span>
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6 shadow-md text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="check_in" class="block text-gray-700 font-medium mb-1">Tanggal Check-in</label>
                    <input type="date" id="check_in" name="check_in"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                </div>
                <div>
                    <label for="check_out" class="block text-gray-700 font-medium mb-1">Tanggal Check-out</label>
                    <input type="date" id="check_out" name="check_out"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                </div>
            </div>

            <div>
                <label for="guests" class="block text-gray-700 font-medium mb-1">Jumlah Tamu</label>
                <input type="number" id="guests" name="guests" min="1" value="1"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div class="text-center">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow">
                    Konfirmasi Pemesanan
                </button>
            </div>
        </form>
    </div>

</body>
</html>
