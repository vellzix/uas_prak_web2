<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen flex flex-col">

    <header class="bg-indigo-600 text-white py-4 shadow">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">My Bookings</h1>
            <a href="{{ route('user.dashboard') }}" class="bg-white text-indigo-600 px-4 py-2 rounded hover:bg-gray-100">Kembali ke Dashboard</a>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="text-center text-gray-600">
                <p>Anda belum memiliki pesanan.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-blue-100 text-left text-sm font-semibold text-gray-700">
                            <th class="p-4 border-b">Hotel</th>
                            <th class="p-4 border-b">Check-in</th>
                            <th class="p-4 border-b">Check-out</th>
                            <th class="p-4 border-b">Jumlah Tamu</th>
                            <th class="p-4 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $booking->service->name }}</td>
                                <td class="p-4">{{ $booking->check_in }}</td>
                                <td class="p-4">{{ $booking->check_out }}</td>
                                <td class="p-4">{{ $booking->guests }}</td>
                                <td class="p-4 flex space-x-2">
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>

    <footer class="bg-gray-200 text-center py-4 mt-10">
        <p class="text-sm text-gray-600">&copy; {{ date('Y') }} Booking Hotel App</p>
    </footer>

</body>
</html>
