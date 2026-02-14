
<?php $__env->startSection('content'); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <div class="mb-6 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Cari Teman Mabar</h1>
            <p class="text-gray-500">Temukan room yang tersedia di lapangan terdekat.</p>
        </div>
    </div>

    <div class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl shadow-lg p-6 mb-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl font-bold flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                Punya Kode Undangan?
            </h2>
            <p class="text-emerald-100 text-sm mt-1">Masukan 6 digit kode unik dari temanmu untuk langsung bergabung.</p>
        </div>

        <form action="<?php echo e(route('rooms.join_code')); ?>" method="POST" class="flex w-full md:w-auto gap-2 relative z-10">
            <?php echo csrf_field(); ?>
            <input type="text" name="code" placeholder="CONTOH: X7K9LP" class="w-full md:w-64 px-5 py-3 rounded-xl text-gray-800 font-bold uppercase tracking-widest focus:outline-none focus:ring-4 focus:ring-emerald-300 shadow-md placeholder-gray-400" required>
            <button class="bg-gray-900 hover:bg-black text-white font-bold px-6 py-3 rounded-xl shadow-md transition transform active:scale-95 flex items-center gap-2">
                GABUNG
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Atau Cari Manual</h3>
        
        <form action="<?php echo e(route('cari.mabar')); ?>" method="GET" id="searchForm">
            <input type="hidden" name="lat" id="lat" value="<?php echo e(request('lat')); ?>">
            <input type="hidden" name="lng" id="lng" value="<?php echo e(request('lng')); ?>">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 items-end">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Olahraga</label>
                    <select name="sport_id" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500">
                        <option value="">Semua Olahraga</option>
                        <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->id); ?>" <?php echo e(request('sport_id') == $s->id ? 'selected' : ''); ?>><?php echo e($s->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Kota</label>
                    <select name="city" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500">
                        <option value="">Semua Kota</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c); ?>" <?php echo e(request('city') == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <button type="button" onclick="getLocation()" class="w-full bg-blue-50 text-blue-600 border border-blue-100 font-bold py-3 px-4 rounded-xl hover:bg-blue-100 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Urutkan Terdekat
                    </button>
                </div>

                <div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg transition transform active:scale-95">
                        Cari Room
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 h-[600px] bg-white rounded-3xl shadow-lg border border-gray-200 overflow-hidden relative z-0">
            <div id="map" class="w-full h-full z-0"></div>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-bold text-xl text-gray-800">Lapangan Tersedia</h3>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full"><?php echo e(count($venues)); ?> Tempat</span>
            </div>

            <div class="h-[550px] overflow-y-auto pr-2 space-y-4 custom-scrollbar">
                <?php $__empty_1 = true; $__currentLoopData = $venues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $venue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer group"
                     onclick="focusVenue(<?php echo e($venue->latitude); ?>, <?php echo e($venue->longitude); ?>)">
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 flex items-center justify-center rounded-xl font-bold text-lg">
                                <?php echo e($index + 1); ?>

                            </div>
                        </div>
                        
                        <div class="flex-grow">
                            <h4 class="font-bold text-gray-900 line-clamp-1"><?php echo e($venue->name); ?></h4>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <?php echo e($venue->city); ?>

                            </p>

                            <?php if(isset($venue->distance)): ?>
                            <div class="mt-2 text-xs text-blue-600 font-medium">
                                Jarak: <?php echo e(number_format($venue->distance, 1)); ?> km
                            </div>
                            <?php endif; ?>

                            <a href="<?php echo e(route('venues.rooms', $venue->id)); ?>" class="mt-3 block w-full text-center bg-emerald-600 text-white hover:bg-emerald-700 py-2 rounded-lg text-xs font-bold transition shadow-md">
                                Lihat Room Disini
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center p-10 text-gray-400">
                    <p>Tidak ada lapangan dengan room aktif.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([-6.9175, 107.6191], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    var venues = <?php echo json_encode($venues, 15, 512) ?>;
    
    venues.forEach((venue, index) => {
        var marker = L.marker([venue.latitude, venue.longitude]).addTo(map);
        marker.bindPopup(`
            <div class="text-center">
                <b>${venue.name}</b><br>
                <a href="/venues/${venue.id}/rooms" class="mt-2 inline-block bg-emerald-600 text-white text-xs px-3 py-1 rounded">Lihat Room</a>
            </div>
        `);
    });

    function getLocation() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                document.getElementById('lat').value = pos.coords.latitude;
                document.getElementById('lng').value = pos.coords.longitude;
                document.getElementById('searchForm').submit();
            });
        } else { alert('GPS error'); }
    }
    
    function focusVenue(lat, lng) { map.flyTo([lat, lng], 15); }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Laravel\reclub-app\resources\views/venues/browse_rooms.blade.php ENDPATH**/ ?>