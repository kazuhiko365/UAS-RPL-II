

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

            <div class="px-8 py-10 bg-gradient-to-br from-emerald-600 to-teal-700 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                <div
                    class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-emerald-400 opacity-10 rounded-full blur-2xl">
                </div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-3xl font-black tracking-tight">Buat Room Baru</h2>
                        <p class="text-emerald-100 mt-1 text-sm font-medium">Isi detail di bawah untuk mulai mabar seru!</p>
                    </div>

                    <button type="button" onclick="cariLapanganDenganData()"
                        class="group flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 px-5 py-2.5 rounded-2xl font-bold text-sm hover:bg-white/20 transition shadow-sm cursor-pointer">
                        <div class="bg-white/20 p-1.5 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 00-.553-.894L15 7m0 13V7">
                                </path>
                            </svg>
                        </div>
                        Cari Lapangan
                    </button>
                </div>
            </div>

            <div class="p-8 lg:p-12">
                <form action="<?php echo e(route('rooms.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-10">
                        <h3 class="text-emerald-900 font-bold text-lg mb-6 flex items-center gap-2">
                            <span
                                class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center text-sm font-black">1</span>
                            Informasi Aktivitas
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Judul Room <span
                                        class="text-red-500">*</span></label>
                                <input type="text" id="title" name="title"
                                    value="<?php echo e(old('title', request('title') ?? '')); ?>"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition placeholder-gray-400 font-medium"
                                    placeholder="Contoh: Mabar Futsal Santai Jumat Malam" required>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-semibold ml-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Cabang Olahraga <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select id="sport_id" name="sport_id"
                                        class="appearance-none w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition cursor-pointer font-medium">
                                        <option value="" disabled <?php echo e((!old('sport_id', request('sport_id'))) ? 'selected' : ''); ?> class="text-gray-400">Pilih Olahraga</option>
                                        <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($s->id); ?>" <?php echo e((old('sport_id', request('sport_id')) == $s->id) ? 'selected' : ''); ?>><?php echo e($s->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['sport_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-semibold ml-1"><?php echo e($message); ?>

                                </p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Lapangan <span
                                        class="text-red-500">*</span></label>

                                <?php if(isset($selectedVenueId) || request('venue_id')): ?>
                                    <div
                                        class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-2 rounded-xl mb-2 text-xs font-bold flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Lokasi dari peta terpilih!
                                    </div>
                                <?php endif; ?>

                                <div class="relative">
                                    <select id="venue_id" name="venue_id"
                                        class="appearance-none w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition cursor-pointer font-medium">
                                        <option value="" disabled <?php echo e((!isset($selectedVenueId) && !request('venue_id')) ? 'selected' : ''); ?> class="text-gray-400">Pilih Lokasi</option>
                                        <?php $__currentLoopData = $venues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($venue->id); ?>" <?php echo e((old('venue_id', $selectedVenueId ?? request('venue_id')) == $venue->id) ? 'selected' : ''); ?>>
                                                <?php echo e($venue->name); ?> - <?php echo e($venue->city); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['venue_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-semibold ml-1"><?php echo e($message); ?>

                                </p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Tambahan <span
                                        class="text-gray-400 font-normal">(Opsional)</span></label>
                                <textarea id="description" name="description" rows="3"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3 transition placeholder-gray-400 font-medium"
                                    placeholder="Tulis info penting: bawa raket sendiri, patungan di lokasi, level pemula welcome, dll."><?php echo e(old('description', request('description') ?? '')); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 mb-10">

                    <div class="mb-10">
                        <h3 class="text-emerald-900 font-bold text-lg mb-6 flex items-center gap-2">
                            <span
                                class="bg-emerald-100 text-emerald-600 w-8 h-8 rounded-full flex items-center justify-center text-sm font-black">2</span>
                            Jadwal & Biaya
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Mulai <span
                                        class="text-red-500">*</span></label>
                                <input type="datetime-local" id="start_datetime" name="start_datetime"
                                    value="<?php echo e(old('start_datetime', request('start_datetime') ?? '')); ?>"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition font-medium"
                                    required>
                                <?php $__errorArgs = ['start_datetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-semibold ml-1">
                                <?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Maks. Peserta</label>
                                <div class="relative">
                                    <input type="number" id="max_participants" name="max_participants"
                                        value="<?php echo e(old('max_participants', request('max_participants', 10) ?? '')); ?>"
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block px-4 py-3.5 transition font-bold text-center">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 text-sm font-bold bg-gray-100 rounded-r-xl border-l border-gray-200">
                                        Orang
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Biaya per Orang</label>
                                <div class="relative">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-emerald-600 font-black text-sm">
                                        Rp
                                    </div>
                                    <input type="number" step="1000" id="cost_per_person" name="cost_per_person"
                                        value="<?php echo e(old('cost_per_person', request('cost_per_person', 0) ?? '')); ?>"
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block pl-12 pr-4 py-3.5 transition font-bold"
                                        placeholder="0">
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1 ml-1">*Isi 0 jika gratis.</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-emerald-200/50 transition transform active:scale-[0.99] flex justify-center items-center gap-2 text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Room Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sportSelect = document.getElementById('sport_id');
            const venueSelect = document.getElementById('venue_id');

            // Simpan selected venue jika ada (misal dari old input)
            const currentSelectedVenue = "<?php echo e(old('venue_id', $selectedVenueId ?? request('venue_id'))); ?>";

            // Fungsi fetch venues
            function fetchVenues(sportId) {
                if (!sportId) return;

                // Tampilkan loading state
                venueSelect.innerHTML = '<option>Loading...</option>';
                venueSelect.disabled = true;

                fetch(`<?php echo e(route('venues.filterBySport')); ?>?sport_id=${sportId}`)
                    .then(response => response.json())
                    .then(data => {
                        venueSelect.innerHTML = '<option value="" disabled selected class="text-gray-400">Pilih Lokasi</option>';

                        if (data.length === 0) {
                            venueSelect.innerHTML += '<option disabled>Tidak ada lapangan untuk olahraga ini</option>';
                        } else {
                            data.forEach(venue => {
                                const isSelected = venue.id == currentSelectedVenue ? 'selected' : '';
                                const option = `<option value="${venue.id}" ${isSelected}>${venue.name} - ${venue.city}</option>`;
                                venueSelect.innerHTML += option;
                            });
                        }
                        venueSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching venues:', error);
                        venueSelect.innerHTML = '<option disabled>Gagal memuat data lapangan</option>';
                    });
            }

            // Event Listener saat Sport Berubah
            if (sportSelect) {
                sportSelect.addEventListener('change', function () {
                    fetchVenues(this.value);
                });

                // Trigger saat halaman load jika sudah ada sport terpilih (misal old input error)
                if (sportSelect.value) {
                    fetchVenues(sportSelect.value);
                }
            }
        });

        function cariLapanganDenganData() {
            // 1. Ambil Value dari Inputan
            // Menggunakan ID yang sudah kita pastikan ada
            const title = document.getElementById('title')?.value || '';
            const sportId = document.getElementById('sport_id')?.value || '';
            const desc = document.getElementById('description')?.value || '';
            const startDate = document.getElementById('start_datetime')?.value || '';
            const maxPart = document.getElementById('max_participants')?.value || '';
            const cost = document.getElementById('cost_per_person')?.value || '';
            const venueId = document.getElementById('venue_id')?.value || '';

            // 2. Tentukan Base URL route cari lapangan
            let baseUrl = "<?php echo e(route('venues.search')); ?>";

            // 3. Rakit Parameter
            const params = new URLSearchParams();

            // Tambahkan hanya jika value-nya tidak kosong (kecuali untuk cost_per_person yang mungkin 0)
            if (title) params.set('title', title);
            if (sportId) params.set('sport_id', sportId);
            if (desc) params.set('description', desc);
            if (startDate) params.set('start_datetime', startDate);
            if (maxPart) params.set('max_participants', maxPart);
            if (cost) params.set('cost_per_person', cost);
            // Kita juga bisa tambahkan venue_id jika sudah terpilih, agar tidak hilang saat pindah.
            if (venueId) params.set('venue_id', venueId);


            // 4. Pindah halaman (Redirect) membawa data-data tadi
            window.location.href = `${baseUrl}?${params.toString()}`;
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/rooms/create.blade.php ENDPATH**/ ?>