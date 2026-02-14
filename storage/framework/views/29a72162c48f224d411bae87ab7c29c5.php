
<?php $__env->startSection('content'); ?>

<div class="relative bg-gray-900 text-white overflow-hidden rounded-b-3xl shadow-xl -mt-6 mb-10">
    <div class="absolute inset-0 opacity-20">
        <svg class="h-full w-full" width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg"><circle cx="400" cy="400" fill="none" r="200" stroke-width="50" stroke="#10b981" opacity="0.5"></circle><circle cx="400" cy="400" fill="none" r="350" stroke-width="30" stroke="#34d399" opacity="0.3"></circle></svg>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-end justify-between gap-6">
        <div>
            <a href="<?php echo e(route('cari.mabar')); ?>" class="inline-flex items-center text-emerald-300 hover:text-white text-sm font-bold mb-4 transition gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Peta
            </a>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-2"><?php echo e($venue->name); ?></h1>
            <div class="flex items-center gap-2 text-gray-300 text-sm md:text-base">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <?php echo e($venue->address); ?>, <?php echo e($venue->city); ?>

            </div>
        </div>
        
        <div class="bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/20">
            <span class="block text-xs text-gray-300 uppercase tracking-widest">Room Aktif</span>
            <span class="text-3xl font-black text-emerald-400"><?php echo e($rooms->count()); ?></span>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

    <?php if($rooms->count() > 0): ?>
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
            <span class="w-1.5 h-8 bg-emerald-500 rounded-full"></span>
            Pilih Jadwal Main
        </h2>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
            
            <div class="h-28 bg-gradient-to-r from-slate-800 to-slate-900 relative p-5">
                <div class="absolute top-4 right-4">
                    <span class="bg-white/20 backdrop-blur text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-white/10">
                        <?php echo e($room->sport->name); ?>

                    </span>
                </div>
                <div class="absolute -bottom-6 left-6">
                    <img src="https://ui-avatars.com/api/?name=<?php echo e($room->host->name); ?>&background=10b981&color=fff" class="w-14 h-14 rounded-2xl border-4 border-white shadow-md group-hover:scale-110 transition duration-300">
                </div>
            </div>

            <div class="p-6 pt-10 flex-grow flex flex-col">
                <div class="mb-4">
                    <p class="text-xs text-gray-400 font-bold uppercase mb-1">Host: <?php echo e($room->host->name); ?></p>
                    <h3 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-emerald-600 transition"><?php echo e($room->title); ?></h3>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <span class="block text-xs text-gray-400 mb-1">Jadwal</span>
                        <span class="block text-sm font-bold text-gray-800"><?php echo e($room->start_datetime->format('d M')); ?></span>
                        <span class="block text-xs text-emerald-600 font-bold"><?php echo e($room->start_datetime->format('H:i')); ?> WIB</span>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <span class="block text-xs text-gray-400 mb-1">Biaya</span>
                        <span class="block text-sm font-bold text-gray-800">Rp <?php echo e(number_format($room->cost_per_person/1000, 0)); ?>rb</span>
                        <span class="block text-xs text-gray-400">/org</span>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between text-xs mb-1 font-bold">
                        <span class="<?php echo e($room->participants->count() >= $room->max_participants ? 'text-red-500' : 'text-gray-500'); ?>">
                            <?php echo e($room->participants->count()); ?> Terisi
                        </span>
                        <span class="text-gray-400">Max <?php echo e($room->max_participants); ?></span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 <?php echo e($room->participants->count() >= $room->max_participants ? 'bg-red-500' : 'bg-emerald-500'); ?>" 
                             style="width: <?php echo e(($room->participants->count() / $room->max_participants) * 100); ?>%">
                        </div>
                    </div>
                </div>

                <div class="mt-auto">
                    <?php if($room->participants->count() >= $room->max_participants): ?>
                        <button disabled class="w-full bg-gray-100 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">
                            Penuh
                        </button>
                    <?php else: ?>
                        <a href="<?php echo e(route('rooms.show', $room)); ?>" class="flex items-center justify-center gap-2 w-full bg-gray-900 text-white hover:bg-emerald-600 font-bold py-3 rounded-xl transition shadow-lg transform active:scale-95">
                            Gabung Sekarang
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full flex flex-col items-center justify-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200 text-center">
            <div class="bg-gray-50 p-4 rounded-full mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Room Aktif</h3>
            <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">Jadilah orang pertama yang membuat jadwal main di lapangan ini.</p>
            
            <a href="<?php echo e(route('rooms.create', ['venue_id' => $venue->id])); ?>" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-full transition shadow-lg hover:shadow-emerald-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Room Disini
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/venues/room_list.blade.php ENDPATH**/ ?>