@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <h2 class="text-3xl font-black text-gray-900">Reset Password</h2>
            <p class="mt-2 text-sm text-gray-600">Buat password baru untuk akun Anda.</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required class="appearance-none rounded-xl block w-full px-4 py-3 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500" value="{{ $email ?? old('email') }}" readonly>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Password Baru</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-xl block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Minimal 8 karakter">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none rounded-xl block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Ulangi password baru">
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition shadow-lg mt-6">
                Simpan Password Baru
            </button>
        </form>
    </div>
</div>
@endsection