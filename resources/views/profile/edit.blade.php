@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="max-w-lg mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Edit Profil</h2>
            <p class="text-sm text-slate-500">Perbarui nama dan foto profil Anda.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6">
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    {{-- Foto Profil --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Foto Profil</label>
                        <div class="flex items-center gap-5">
                            <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden border-2 border-slate-200">
                                @if ($user->photo)
                                    <img src="{{ Storage::url($user->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-2xl font-bold text-slate-400">{{ substr($user->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <input type="file" name="photo" accept="image/jpeg,image/png"
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors cursor-pointer">
                                <p class="text-xs text-slate-400 mt-1">Maks 2MB, format JPG/PNG.</p>
                                @if ($user->photo)
                                    <label class="inline-flex items-center gap-2 mt-2 text-xs text-red-600 cursor-pointer hover:text-red-700">
                                        <input type="checkbox" name="remove_photo" value="1" class="rounded border-slate-300 text-red-500 focus:ring-red-400">
                                        Hapus foto profil
                                    </label>
                                @endif
                                @error('photo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('name') border-red-400 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email (read-only) --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-slate-500 cursor-not-allowed">
                        <p class="text-xs text-slate-400 mt-1">Email digunakan untuk login dan tidak bisa diubah.</p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-4 pt-2 border-t">
                        <button type="submit"
                            class="px-5 py-2.5 bg-primary hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-sm transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-save"></i> Simpan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                                class="text-sm text-emerald-600 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Tersimpan
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Ganti Password --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-800">Ganti Password</h3>
            </div>
            <div class="p-6">
                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors text-sm @error('current_password', 'updatePassword') border-red-400 @enderror">
                        @error('current_password', 'updatePassword')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors text-sm @error('password', 'updatePassword') border-red-400 @enderror">
                        @error('password', 'updatePassword')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors text-sm">
                    </div>

                    <div class="flex items-center gap-4 pt-2 border-t">
                        <button type="submit"
                            class="px-5 py-2.5 bg-slate-700 hover:bg-slate-800 text-white text-sm font-bold rounded-lg shadow-sm transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-key"></i> Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
