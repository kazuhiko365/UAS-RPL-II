<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'SportClub')); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                
                
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 group">
                        <div class="bg-emerald-600 text-white p-2 rounded-xl group-hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-gray-800">
                            Sport<span class="text-emerald-600">Club</span>
                        </span>
                    </a>
                    
                    
                    <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                        <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-emerald-600'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition">
                            Beranda
                        </a>

                        <?php if(auth()->guard()->check()): ?>
                            <?php if(!auth()->user()->isAdmin()): ?> 
                                <a href="<?php echo e(route('cari.mabar')); ?>" class="<?php echo e(request()->routeIs('cari.mabar') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-emerald-600'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition">
                                    Cari Mabar
                                </a>
                                <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-emerald-600'); ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition">
                                    Dashboard Saya
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="flex items-center gap-4">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <div class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full font-bold uppercase tracking-wide">Admin Panel</div>
                        <?php endif; ?>
                        
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-emerald-600 transition">
                                
                                <img src="<?php echo e(Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=10b981&color=fff'); ?>" 
                                     class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                                
                                <span class="hidden md:inline"><?php echo e(Auth::user()->name); ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50 overflow-hidden">
                                
                                
                                <?php if(!auth()->user()->isAdmin()): ?>
                                    <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 font-medium">
                                        📊 Dashboard
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">Admin Dashboard</a>
                                <?php endif; ?>

                                
                                <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 font-medium border-t border-gray-50">
                                    👤 Pengaturan Akun
                                </a>

                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-medium flex items-center gap-2 border-t border-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-gray-500 hover:text-emerald-600 font-medium text-sm">Masuk</a>
                        <a href="<?php echo e(route('register')); ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-emerald-200 transition transform hover:-translate-y-0.5">
                            Daftar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        <?php if(session('success')): ?>
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r shadow-sm flex justify-between">
                    <p><?php echo e(session('success')); ?></p>
                    <span onclick="this.parentElement.remove()" class="cursor-pointer font-bold">&times;</span>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm flex justify-between">
                    <p><?php echo e(session('error')); ?></p>
                    <span onclick="this.parentElement.remove()" class="cursor-pointer font-bold">&times;</span>
                </div>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-white border-t border-gray-100 mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex justify-center text-gray-500 text-sm">
            <span class="font-bold text-gray-800">SportClub &copy; <?php echo e(date('Y')); ?></span>
        </div>
    </footer>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Laravel\reclub-app\resources\views/layouts/app.blade.php ENDPATH**/ ?>