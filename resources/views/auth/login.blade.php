<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PLTMH</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md relative z-10">
        <h2 class="text-2xl font-bold text-center mb-6 text-slate-800">Login Administrator</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                {{-- Tambahkan value="{{ old('email') }}" agar input tidak hilang saat error --}}
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                Masuk
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-blue-600">Kembali ke Dashboard</a>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- MODAL ERROR LOGIN (DIALOG BOX)             --}}
    {{-- ========================================== --}}
    @if ($errors->has('login_error'))
    <div id="errorModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-sm w-full mx-4 p-6 border-t-4 border-red-500">
            <div class="text-center">
                {{-- Icon X Merah --}}
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

                {{-- Judul Error --}}
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    Login Gagal
                </h3>

                {{-- Pesan Error Dinamis dari Controller --}}
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        {{ $errors->first('login_error') }}
                    </p>
                </div>

                {{-- Tombol Tutup --}}
                <div class="mt-5">
                    <button type="button" onclick="document.getElementById('errorModal').style.display='none'"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</body>

</html>