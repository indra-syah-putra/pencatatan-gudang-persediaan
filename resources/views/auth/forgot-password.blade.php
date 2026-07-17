<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - {{ config('app.name', 'PT. Jaya Raya') }}</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans text-slate-800 antialiased bg-slate-50 h-screen flex items-center justify-center p-4 overflow-hidden">
    <div class="w-full max-w-sm">
        <div class="text-center mb-5">
            <div class="w-14 h-14 rounded-2xl bg-amber-500 flex items-center justify-center text-white font-bold text-2xl mx-auto shadow-lg mb-3">
                <i class="fa-solid fa-key"></i>
            </div>
            <h1 class="text-xl font-extrabold text-slate-900">Lupa Password?</h1>
            <p class="text-xs text-slate-500 font-semibold">Masukkan email Anda untuk reset password.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            @if (isset($resetUrl))
                <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4 mb-4">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span class="text-xs font-bold text-emerald-700">Link reset password sudah siap!</span>
                    </div>
                    <a href="{{ $resetUrl }}"
                        class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-colors text-sm">
                        <i class="fa-solid fa-key"></i> Reset Password
                    </a>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-100 text-red-700 px-3 py-2 rounded-lg text-xs font-bold flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ $errors->first('email') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $email ?? '') }}" required autofocus
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition-colors text-sm">
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition-colors text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Link Reset
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('admin.login') }}" class="text-xs text-slate-500 hover:text-slate-700">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </div>

        <p class="text-center text-[10px] text-slate-400 mt-4">ERP System &copy; {{ config('app.name', 'PT. Jaya Raya') }}</p>
    </div>
</body>
</html>
