@extends('layouts.app')

@section('title', 'Dashboard - Laporan Stok')

@section('content')
    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Laporan Stok</h2>
            <p class="text-slate-500">Monitoring persediaan real-time & input transaksi.</p>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Total Item --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Item</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalItems }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-cubes"></i>
            </div>
        </div>

        {{-- Stok Tipis --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Tipis</p>
                <h3 class="text-3xl font-bold text-red-600 mt-2">{{ $lowStockCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Sistem</p>
                <h3 class="text-xl font-bold text-green-600 mt-2">Normal</h3>
            </div>
            <div
                class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-check"></i>
            </div>
        </div>
    </div>

    {{-- TABEL LAPORAN --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Daftar Persediaan</h3>
            <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded"><i class="fa-solid fa-sync mr-1"></i> Live
                Data</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-xs font-bold text-slate-500 uppercase border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 w-1/3">Nama Barang</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($barangs as $item)
                        @php
                            $currentStock = $item->persediaan?->quantity ?? 0;
                            $isLow = $currentStock <= $item->min_stock;
                        @endphp

                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $item->name }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold border border-slate-200">{{ $item->category }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-slate-900 font-bold text-lg">{{ $currentStock }}</span>
                                <span class="text-slate-400 text-xs ml-1">{{ $item->unit_of_measure }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($isLow)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Tipis
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aman
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada data persediaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Table --}}
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
            <p class="text-center text-xs text-slate-500">Menampilkan {{ $barangs->count() }} master barang.</p>
        </div>
    </div>
@endsection
