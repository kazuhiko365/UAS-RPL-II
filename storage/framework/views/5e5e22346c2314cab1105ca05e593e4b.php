

<?php $__env->startSection('content'); ?>

    <?php
        $dataTitipan = request()->only([
            'title',
            'description',
            'start_datetime',
            'max_participants',
            'cost_per_person',
            'sport_id'
        ]);
    ?>

    <div class="container mx-auto px-4 py-6">

        <div class="bg-white p-6 rounded-3xl shadow-lg mb-6 border border-gray-100">
            <h2 class="text-xl font-bold mb-4 flex items-center text-gray-800">
                <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Pilih Lokasi Lapangan
            </h2>

            <form id="searchForm" method="GET" action="<?php echo e(route('venues.search')); ?>"
                class="grid grid-cols-1 md:grid-cols-12 gap-4">

                <?php $__currentLoopData = $dataTitipan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pilih Kota</label>
                    <div class="relative">
                        <select name="city"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-emerald-500 focus:border-emerald-500 appearance-none font-bold text-gray-700 cursor-pointer">
                            <option value="">Semua Kota</option>
                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city); ?>" <?php echo e(request('city') == $city ? 'selected' : ''); ?>>
                                    <?php echo e($city); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama / Alamat Lapangan</label>
                    <div class="relative">
                        <input type="text" name="keyword" value="<?php echo e(request('keyword')); ?>"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-4 pr-4 py-2.5 text-sm focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                            placeholder="Cari berdasarkan nama atau alamat...">
                    </div>
                </div>

                <div class="md:col-span-2 flex items-end">
                    <button type="submit"
                        class="w-full bg-gray-800 text-white py-2.5 rounded-xl hover:bg-black font-bold shadow-md transition text-sm flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-md border border-gray-200 overflow-hidden">
            <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Hasil Pencarian</h3>
                <span
                    class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full"><?php echo e($venues->count()); ?>

                    Lokasi</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                <?php $__empty_1 = true; $__currentLoopData = $venues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        class="border border-gray-100 rounded-2xl p-4 hover:shadow-md hover:border-emerald-200 transition bg-white group h-full flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-gray-900 group-hover:text-emerald-600 transition text-lg">
                                        <?php echo e($venue->name); ?></h4>
                                    <p class="text-sm text-gray-500 mb-2"><?php echo e($venue->city); ?></p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 mt-1">
                                <div class="flex items-center bg-yellow-50 px-2 py-0.5 rounded-md border border-yellow-100">
                                    <span class="text-xs font-bold text-gray-700">★ <?php echo e($venue->rating); ?></span>
                                </div>
                                <div class="text-xs font-bold text-gray-600">
                                    Rp <?php echo e(number_format($venue->price_per_hour, 0, ',', '.')); ?> / jam
                                </div>
                            </div>

                            <p class="text-xs text-gray-400 mt-2 line-clamp-2"><?php echo e($venue->address); ?></p>
                        </div>

                        <button type="button" onclick="selectVenue(<?php echo e($venue->id); ?>)"
                            class="block mt-4 w-full bg-emerald-600 text-white hover:bg-emerald-700 py-2.5 rounded-xl text-sm font-bold transition shadow-sm">
                            Pilih Lapangan Ini
                        </button>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full flex flex-col items-center justify-center h-40 text-gray-400">
                        <p class="text-sm">Tidak ada lapangan ditemukan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // VITAL: Inject saved PHP data into JavaScript
        const savedInputs = <?php echo json_encode($dataTitipan, 15, 512) ?>;
        const createRoomBaseUrl = "<?php echo e(route('rooms.create')); ?>";

        // --- URL CONSTRUCTION LOGIC ---
        function getFinalUrl(venueId) {
            const params = new URLSearchParams(savedInputs);
            params.set('venue_id', venueId);
            return `${createRoomBaseUrl}?${params.toString()}`;
        }

        // Function triggered by clicking "Pilih Lapangan Ini"
        function selectVenue(venueId) {
            window.location.href = getFinalUrl(venueId);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/venues/map_search.blade.php ENDPATH**/ ?>