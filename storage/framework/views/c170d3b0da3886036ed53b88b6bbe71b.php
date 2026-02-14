
<?php $__env->startSection('content'); ?>

<div class="relative bg-emerald-900 overflow-hidden mb-10">
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <svg class="h-full w-full" width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg"><circle cx="400" cy="400" fill="none" r="200" stroke-width="50" stroke="#10b981" opacity="0.5"></circle><circle cx="400" cy="400" fill="none" r="350" stroke-width="30" stroke="#34d399" opacity="0.3"></circle></svg>
    </div>
    
    <div class="relative max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center md:text-left">
        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl mb-4">
            Cari Lawan Main?
        </h1>
        <p class="mt-2 max-w-2xl text-base text-emerald-100 sm:text-lg mb-8 mx-auto md:mx-0">
            Temukan komunitas olahraga, booking lapangan, dan main bareng sekarang.
        </p>
        
        <?php if(!auth()->check() || (auth()->check() && !auth()->user()->isAdmin())): ?>
        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
            <a href="<?php echo e(route('cari.mabar')); ?>" class="px-8 py-3 bg-white text-emerald-800 font-bold rounded-full shadow-lg hover:bg-emerald-50 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Cari Room
            </a>

            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="px-8 py-3 bg-emerald-700 border border-emerald-600 text-white font-bold rounded-full shadow-lg hover:bg-emerald-600 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                Masuk Kode Room
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8 sticky top-20 z-30">
        <form action="<?php echo e(route('home')); ?>" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
            <div class="w-full relative">
                <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" placeholder="Cari nama room atau lokasi..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
            </div>
            <select name="sport" class="w-full md:w-48 py-2.5 px-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none bg-white">
                <option value="">Semua Sport</option>
                <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e(request('sport') == $s->id ? 'selected' : ''); ?>><?php echo e($s->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="w-full md:w-auto bg-gray-900 hover:bg-emerald-600 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-md">
                Filter
            </button>
        </form>
    </div>

    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
        <span class="w-1.5 h-8 bg-emerald-500 rounded-full"></span>
        Jadwal Main Terbaru
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
            
            <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-700 relative p-5 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <span class="bg-white/20 backdrop-blur text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-white/10">
                        <?php echo e($room->sport->name); ?>

                    </span>
                    <?php if(isset($room->distance_km)): ?>
                    <span class="bg-black/30 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded-lg flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <?php echo e(number_format($room->distance_km, 1)); ?> km
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="p-6 pt-8 relative flex-grow flex flex-col">
                <div class="absolute -top-8 left-6">
                    <img src="<?php echo e($room->host->avatar ? asset('storage/' . $room->host->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($room->host->name) . '&background=ffffff&color=10b981&bold=true'); ?>" 
                         class="w-16 h-16 rounded-2xl border-4 border-white shadow-md group-hover:scale-105 transition duration-300 bg-white object-cover">
                </div>

                <div class="mb-1">
                    <p class="text-xs text-gray-400 font-bold uppercase mb-1 ml-16 pl-2">Host: <?php echo e(Str::limit($room->host->name, 15)); ?></p>
                </div>

                <h3 class="text-lg font-bold text-gray-900 leading-snug mb-2 group-hover:text-emerald-600 transition line-clamp-2 min-h-[3.5rem]">
                    <?php echo e($room->title); ?>

                </h3>
                
                <p class="text-xs text-gray-500 mb-5 flex items-center gap-1">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <?php echo e(Str::limit($room->venue->name, 35)); ?>

                </p>

                <div class="grid grid-cols-2 gap-3 mb-5">
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100 flex flex-col justify-center">
                        <span class="text-[10px] text-gray-400 uppercase font-bold">Waktu</span>
                        <div class="text-sm font-bold text-gray-800"><?php echo e($room->start_datetime->format('d M')); ?></div>
                        <div class="text-xs text-emerald-600 font-bold"><?php echo e($room->start_datetime->format('H:i')); ?> WIB</div>
                    </div>
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-100 flex flex-col justify-center">
                        <span class="text-[10px] text-gray-400 uppercase font-bold">Biaya</span>
                        <div class="text-sm font-bold text-gray-800">Rp <?php echo e(number_format($room->cost_per_person/1000, 0)); ?>rb</div>
                        <div class="text-xs text-gray-400">per orang</div>
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                    <div class="flex -space-x-2 overflow-hidden items-center">
                        <?php $__currentLoopData = $room->participants->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-white object-cover" 
                                 src="<?php echo e($p->user->avatar ? asset('storage/' . $p->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($p->user->name) . '&background=random'); ?>" 
                                 title="<?php echo e($p->user->name); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($room->participants->count() > 3): ?>
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full ring-2 ring-white bg-gray-100 text-[9px] font-bold text-gray-500">
                                +<?php echo e($room->participants->count() - 3); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo e(route('rooms.show', $room)); ?>" class="text-sm font-bold text-emerald-600 hover:text-emerald-800 transition flex items-center gap-1 group/link">
                        Lihat Detail 
                        <span aria-hidden="true" class="group-hover/link:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mb-12">
        <?php echo e($rooms->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Laravel\reclub-app\resources\views/rooms/index.blade.php ENDPATH**/ ?>