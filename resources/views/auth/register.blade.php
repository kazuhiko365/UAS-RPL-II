@extends('layouts.app')
@section('content')

<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center items-center gap-2 mb-6">
            <div class="bg-emerald-600 text-white p-2 rounded-xl shadow-lg shadow-emerald-200">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="font-bold text-3xl tracking-tight text-gray-900">Sport<span class="text-emerald-600">Club</span></span>
        </div>
        <h2 class="text-center text-2xl font-extrabold text-gray-900">
            Daftar Akun Baru
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Bergabung dengan komunitas olahraga sekarang.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl shadow-gray-100 sm:rounded-2xl sm:px-10 border border-gray-100">
            <form class="space-y-5" action="{{ route('register') }}" method="POST">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="mt-1">
                        <input type="text" name="name" value="{{ old('name') }}" required class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                    </div>
                    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <div class="mt-1">
                        <input type="email" name="email" value="{{ old('email') }}" required class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm @error('email') border-red-500 @enderror">
                    </div>
                    @error('email') 
                        <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <div class="mt-1">
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 08123456789" class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                    </div>
                    @error('phone') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input type="password" name="password" required class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm @error('password') border-red-500 @enderror">
                    </div>
                    @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <div class="mt-1">
                        <input type="password" name="password_confirmation" required class="appearance-none block w-full px-3 py-2.5 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                    </div>
                    @error('password') 
                        @if($message == 'Konfirmasi password tidak sesuai.')
                            <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                        @endif 
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition transform hover:-translate-y-0.5">
                        Daftar
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500"> Sudah punya akun? </span>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-500 hover:underline">
                        Masuk disini
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection