@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <h2 class="text-3xl font-black text-gray-900">Lupa Password?</h2>
            <p class="mt-2 text-sm text-gray-600">
                Masukkan email Anda, kami akan mengirimkan link untuk mereset password.
            </p>
        </div>

        @if (session('status'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="sr-only">Email Address</label>
                <input id="email" name="email" type="email" required class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm" placeholder="Masukkan Email Anda" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition shadow-lg">
                    Kirim Link Reset
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-500">
                    &larr; Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection