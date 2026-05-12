@extends('layouts.app')

@section('title', 'Profil Admin')
@section('page_title', 'Pengaturan Akun')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-2xl font-bold text-white shadow-md">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">{{ Auth::user()->name }}</h2>
                <p class="text-slate-500 text-sm">Administrator Sistem</p>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="p-6 md:p-8">
            @csrf
            @method('PUT')

            <h3 class="text-base font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Informasi Dasar</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap Admin <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border {{ $errors->has('name') ? 'border-red-500' : 'border-slate-200' }} p-3 bg-slate-50 focus:bg-white focus:border-primary focus:ring-primary transition-all">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Username Login <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username', $user->email) }}" required class="w-full rounded-xl border {{ $errors->has('username') ? 'border-red-500' : 'border-slate-200' }} p-3 bg-slate-50 focus:bg-white focus:border-primary focus:ring-primary transition-all" placeholder="Misal: admin">
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <h3 class="text-base font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Ganti Kata Sandi (Opsional)</h3>
            <div class="bg-blue-50 text-blue-700 text-sm p-4 rounded-xl flex items-start gap-3 border border-blue-100 mb-6">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Biarkan kedua kolom di bawah ini kosong jika Anda <strong>tidak ingin mengubah</strong> password Anda saat ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                    <input type="password" name="password" class="w-full rounded-xl border {{ $errors->has('password') ? 'border-red-500' : 'border-slate-200' }} p-3 bg-slate-50 focus:bg-white focus:border-primary focus:ring-primary transition-all" placeholder="Minimal 6 karakter">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full rounded-xl border border-slate-200 p-3 bg-slate-50 focus:bg-white focus:border-primary focus:ring-primary transition-all" placeholder="Ketik ulang password baru">
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-md shadow-primary/30 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
