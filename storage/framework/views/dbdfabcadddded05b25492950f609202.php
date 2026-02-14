

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        
        <div class="px-8 py-10 bg-gradient-to-br from-emerald-600 to-teal-700 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-emerald-400 opacity-10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-3xl font-black tracking-tight">Edit Room</h2>
                    <p class="text-emerald-100 mt-1 text-sm font-medium">Perbarui detail jadwal atau lokasi room Anda.</p>
                </div>
                <a href="<?php echo e(route('rooms.show', $room)); ?>" class="group flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-5 py-2.5 rounded-2xl font-bold text-sm hover:bg-white/20 transition shadow-sm">
                    <div class="bg-white/20 p-1.5 rounded-lg group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </div>
                    Kembali
                </a>
            </div>
        </div>

        <div class="p-8 lg:p-12">
            <form action="<?php echo e(route('rooms.update', $room)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="mb-10">
                    <h3 class="text-emerald-900 font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center text-sm font-black">1</span>
                        Informasi Aktivitas
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Judul Room <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="<?php echo e(old('title', $room->title)); ?>" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition font-medium" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Cabang Olahraga <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="sport_id" class="appearance-none w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition cursor-pointer font-medium">
                                    <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <option value="<?php echo e($s->id); ?>" <?php echo e(old('sport_id', $room->sport_id) == $s->id ? 'selected' : ''); ?>><?php echo e($s->name); ?></option> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Lapangan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="venue_id" class="appearance-none w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition cursor-pointer font-medium">
                                    <?php $__currentLoopData = $venues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($venue->id); ?>" <?php echo e(old('venue_id', $room->venue_id) == $venue->id ? 'selected' : ''); ?>>
                                            <?php echo e($venue->name); ?> - <?php echo e($venue->city); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Tambahan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <textarea name="description" rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3 transition font-medium"><?php echo e(old('description', $room->description)); ?></textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100 mb-10">

                <div class="mb-10">
                    <h3 class="text-emerald-900 font-bold text-lg mb-6 flex items-center gap-2">
                        <span class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center text-sm font-black">2</span>
                        Jadwal & Biaya
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Mulai <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_datetime" value="<?php echo e(old('start_datetime', $room->start_datetime->format('Y-m-d\TH:i'))); ?>" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition font-medium" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Maks. Peserta</label>
                            <div class="relative">
                                <input type="number" name="max_participants" value="<?php echo e(old('max_participants', $room->max_participants)); ?>" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition font-bold text-center">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 text-sm font-bold bg-gray-100 rounded-r-xl border-l border-gray-200">Orang</div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Biaya per Orang</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-emerald-600 font-black text-sm">Rp</div>
                                <input type="number" step="1000" name="cost_per_person" value="<?php echo e(old('cost_per_person', $room->cost_per_person)); ?>" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-12 pr-4 py-3.5 transition font-bold">
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1 ml-1">*Isi 0 jika gratis.</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-emerald-200/50 transition transform active:scale-[0.99] flex justify-center items-center gap-2 text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/rooms/edit.blade.php ENDPATH**/ ?>