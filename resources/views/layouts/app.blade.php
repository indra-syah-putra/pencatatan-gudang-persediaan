<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ERP ' . company('name'))</title>

    @yield('meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>[x-cloak] { display: none !important; }</style>
    @stack('styles')
</head>

<body class="text-slate-800 antialiased bg-slate-50 flex flex-col min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-bold text-xl overflow-hidden">
                        @php $logo = company('logo'); @endphp
                        @if ($logo)
                            <img src="{{ Storage::url($logo) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(trim(str_replace('PT.', '', company('name'))), 0, 1) }}
                        @endif
                    </div>
                    <div class="hidden md:block">
                        <h1 class="text-lg font-bold text-slate-900 leading-none">{{ strtoupper(str_replace('PT. ', '', company('name'))) }}</h1>
                        <p class="text-[10px] text-slate-500 font-semibold uppercase">ERP System</p>
                    </div>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                        <i class="fa-solid fa-chart-pie"></i> Dashboard
                    </a>

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('barang.index') }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('barang*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                            <i class="fa-solid fa-box-open"></i> Data Barang
                        </a>
                    @endif

                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('laporan*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-primary' }}">
                        <i class="fa-solid fa-print"></i> Laporan
                    </a>

                    <a href="{{ route('transaksi.create') }}"
                        class="flex items-center gap-2 px-5 py-2.5 ml-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-md transition">
                        <i class="fa-solid fa-plus"></i> Transaksi
                    </a>

                    {{-- Profile Dropdown --}}
                    <div class="relative ml-4 pl-4 border-l border-slate-200" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50 transition-colors group">
                            <div class="w-8 h-8 rounded-full bg-primary/10 overflow-hidden flex items-center justify-center group-hover:ring-2 group-hover:ring-primary transition-all">
                                @if (auth()->user()->photo)
                                    <img src="{{ Storage::url(auth()->user()->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-sm font-bold text-primary">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-bold text-slate-700 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold uppercase">{{ auth()->user()->role }}</p>
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.outside="open = false"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-50"
                            x-transition x-cloak>
                            {{-- Info Akun --}}
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ auth()->user()->role === 'admin' ? 'bg-primary/10 text-primary' : 'bg-emerald-50 text-emerald-600' }}">
                                    {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Staff' }}
                                </span>
                            </div>

                            {{-- Menu Items --}}
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary transition-colors">
                                <i class="fa-solid fa-user w-4 text-center"></i>
                                <span>Edit Profil</span>
                            </a>
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('settings.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary transition-colors">
                                    <i class="fa-solid fa-gear w-4 text-center"></i>
                                    <span>Pengaturan</span>
                                </a>
                            @endif

                            <div class="border-t border-slate-100 my-1"></div>

                            {{-- Logout --}}
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile Button --}}
                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-btn" class="text-slate-500 hover:text-primary p-2">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 p-4">
            <a href="{{ route('dashboard') }}" class="block py-2 text-slate-600 font-medium">Dashboard</a>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('barang.index') }}" class="block py-2 text-slate-600 font-medium">Data Barang</a>
            @endif

            <a href="{{ route('laporan.index') }}" class="block py-2 text-slate-600 font-medium">Laporan</a>
            <a href="{{ route('transaksi.create') }}" class="block py-2 text-primary font-bold mt-2">+ Transaksi</a>

            <div class="mt-4 border-t pt-2 space-y-1">
                <div class="flex items-center gap-2 py-2 text-slate-500 text-sm">
                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center text-sm font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="block py-2 text-slate-600 font-medium">Edit Profil</a>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-t">
                @csrf
                <button type="submit" class="text-red-500 text-sm font-bold">Logout</button>
            </form>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition>
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="flex-grow w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        @yield('content')
    </main>

    {{-- Scripts --}}
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>
