

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900">Riwayat Aktivitas</h1>
            <p class="text-gray-500">Jejak keringat dan kenangan mabar Anda.</p>
        </div>
        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2 text-sm font-bold text-gray-600 hover:text-emerald-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <?php if($histories->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden opacity-90 hover:opacity-100 transition shadow-sm hover:shadow-md">
                <div class="bg-gray-100 p-4 border-b border-gray-200 flex justify-between items-center">
                    <span class="bg-gray-200 text-gray-600 text-[10px] font-bold px-2 py-1 rounded uppercase">
                        <?php echo e($room->sport->name); ?>

                    </span>
                    <span class="text-xs text-gray-500 font-bold">
                        <?php echo e($room->start_datetime->format('d M Y')); ?>

                    </span>
                </div>

                <div class="p-5">
                    <h3 class="font-bold text-gray-800 text-lg mb-1 line-clamp-1"><?php echo e($room->title); ?></h3>
                    <p class="text-xs text-gray-500 mb-4 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <?php echo e($room->venue->name); ?>

                    </p>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <img src="<?php echo e($room->host->avatar ? asset('storage/' . $room->host->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($room->host->name) . '&background=random'); ?>" class="w-8 h-8 rounded-full border border-gray-200">
                            <div class="text-xs">
                                <span class="block text-gray-400">Host</span>
                                <span class="font-bold text-gray-700"><?php echo e($room->host_id == auth()->id() ? 'Anda' : Str::limit($room->host->name, 10)); ?></span>
                            </div>
                        </div>
                        
                        <a href="<?php echo e(route('rooms.show', $room)); ?>" class="text-xs font-bold text-gray-500 hover:text-emerald-600 border border-gray-300 px-3 py-1.5 rounded-lg hover:border-emerald-500 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-8">
            <?php echo e($histories->links()); ?>

        </div>
    <?php else: ?>
        <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">🕰️</div>
            <h3 class="text-lg font-bold text-gray-700">Belum ada riwayat</h3>
            <p class="text-gray-500 text-sm">Aktivitas yang sudah selesai akan muncul di sini.</p>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Laravel\reclub-app\resources\views/user/history.blade.php ENDPATH**/ ?>