<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - {{ config('app.name', 'PT. Jaya Raya') }}</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans text-slate-800 antialiased bg-slate-50 h-screen flex items-center justify-center p-4 overflow-hidden">
    <div class="w-full max-w-sm">
        <div class="text-center mb-5">
            <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center text-white font-bold text-2xl mx-auto shadow-lg mb-3">J</div>
            <h1 class="text-xl font-extrabold text-slate-900">{{ strtoupper(str_replace('PT. ', '', config('app.name', 'JAYA RAYA'))) }}</h1>
            <p class="text-xs text-slate-500 font-semibold">Portal Admin</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-100 text-red-700 px-3 py-2 rounded-lg text-xs font-bold flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email Admin</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-colors text-sm">
                </div>

                <div class="mb-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-colors text-sm">
                </div>

                <div class="mb-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Captcha: <span class="text-blue-600 font-extrabold">{{ $captchaData['question'] }}</span>
                    </label>
                    <input type="text" name="captcha" required placeholder="Jawaban"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-colors text-sm @error('captcha') border-red-400 @enderror">
                    @error('captcha')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mb-4">
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline font-medium">Lupa password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition-colors text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-lock"></i> Masuk sebagai Admin
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('staff.login') }}" class="text-xs text-slate-500 hover:text-slate-700">
                    <i class="fa-solid fa-user"></i> Login sebagai Staff
                </a>
            </div>
        </div>

        <p class="text-center text-[10px] text-slate-400 mt-4">ERP System &copy; {{ config('app.name', 'PT. Jaya Raya') }}</p>
    </div>
</body>
</html>
