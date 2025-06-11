<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Pemesanan Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-4">Daftar Akun</h2>

        <!-- Alert jika ada error -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-600 font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Masukkan Nama" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Masukkan Email" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold mb-1">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Masukkan Password" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-semibold mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Konfirmasi Password" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-gray-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 font-semibold">Login di sini</a>
        </p>
    </div>

</body>
</html>
