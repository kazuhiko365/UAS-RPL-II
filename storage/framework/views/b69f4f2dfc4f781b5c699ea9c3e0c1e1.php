

<?php $__env->startSection('content'); ?>


<div id="toast" class="fixed top-24 right-5 bg-gray-900 text-white px-6 py-4 rounded-xl shadow-2xl transform translate-x-full transition-transform duration-300 z-50 flex items-center gap-3 border-l-4 border-emerald-500">
    <div class="bg-emerald-500 rounded-full p-1">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
    </div>
    <div>
        <h4 class="font-bold text-sm">Berhasil!</h4>
        <p class="text-xs text-gray-300">Kode room telah disalin.</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-8">
    
    
    <div class="flex flex-col md:flex-row justify-between items-start mb-8 gap-6">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-3">
                <span class="bg-emerald-100 text-emerald-700 text-xs font-black px-3 py-1 rounded-lg uppercase tracking-wide">
                    <?php echo e($room->sport->name); ?>

                </span>
                <?php if(!$room->is_active): ?>
                    <span class="bg-red-100 text-red-700 text-xs font-black px-3 py-1 rounded-lg uppercase">NONAKTIF</span>
                <?php elseif(now() >= $room->start_datetime): ?>
                    <span class="bg-gray-200 text-gray-700 text-xs font-black px-3 py-1 rounded-lg uppercase">SELESAI</span>
                <?php endif; ?>
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight mb-2"><?php echo e($room->title); ?></h1>
            <div class="flex items-center gap-2 text-gray-500 text-sm">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="font-medium"><?php echo e($room->venue->name); ?></span>
                <span class="text-gray-300 mx-1">|</span>
                <span><?php echo e($room->venue->city); ?></span>
            </div>
        </div>
        
        
        <?php if(auth()->id() == $room->host_id): ?>
        <div class="group relative w-full md:w-auto">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-200"></div>
            <div class="relative bg-white rounded-xl p-5 border border-gray-100 shadow-sm text-center">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-2">KODE UNDANGAN</p>
                <div class="flex items-center justify-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 mb-3">
                    <span class="text-2xl font-mono font-black text-gray-800 tracking-widest select-all" id="roomCodeText"><?php echo e($room->code); ?></span>
                </div>
                <button onclick="copyCode()" class="w-full bg-gray-900 hover:bg-emerald-600 text-white text-xs font-bold py-2.5 rounded-lg transition flex items-center justify-center gap-2 shadow-md active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                    SALIN KODE
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
            <div class="bg-blue-50 text-blue-600 p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase mb-1">Jadwal Main</p>
                <p class="font-bold text-gray-900 text-lg"><?php echo e($room->start_datetime->format('d M Y')); ?></p>
                <p class="text-emerald-600 font-bold"><?php echo e($room->start_datetime->format('H:i')); ?> WIB</p>
            </div>
        </div>

        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-start gap-4">
            <div class="bg-green-50 text-green-600 p-3 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-bold uppercase mb-1">Patungan</p>
                <p class="font-bold text-gray-900 text-2xl">Rp <?php echo e(number_format($room->cost_per_person, 0, ',', '.')); ?></p>
                <p class="text-xs text-gray-400">per orang</p>
            </div>
        </div>

        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center">
            <div class="flex justify-between items-end mb-2">
                <p class="text-xs text-gray-400 font-bold uppercase">Ketersediaan Slot</p>
                <p class="text-sm font-bold text-gray-900"><?php echo e($room->participants->count()); ?> / <?php echo e($room->max_participants); ?></p>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-400 to-green-600 h-full rounded-full transition-all duration-1000 ease-out" style="width: <?php echo e(($room->participants->count() / $room->max_participants) * 100); ?>%"></div>
            </div>
            <p class="text-right text-[10px] text-emerald-600 font-bold mt-2">
                <?php echo e($room->max_participants - $room->participants->count()); ?> tempat tersisa
            </p>
        </div>
    </div>

    
    <div class="mb-12">
        <div class="bg-orange-50 border-l-4 border-orange-400 p-6 rounded-r-xl">
            <h3 class="text-lg font-bold text-orange-800 mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Catatan Host
            </h3>
            <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                <?php echo e($room->description ?: 'Tidak ada catatan khusus dari host.'); ?>

            </p>
        </div>
    </div>

    
    <?php
        $myStatus = $room->participants->firstWhere('user_id', auth()->id())?->status;
        $isHost = auth()->id() == $room->host_id;
        $isAdmin = auth()->user()->role === 'admin';
        $isFull = $room->participants->count() >= $room->max_participants;
        $isStarted = now() >= $room->start_datetime; // LOGIKA WAKTU HABIS
    ?>

    
    <?php if($isAdmin): ?>
        <div class="mb-12 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-6 text-center">
            <div class="flex flex-col items-center justify-center gap-2">
                <div class="bg-gray-200 p-3 rounded-full text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-700">Admin View Mode</h3>
                <p class="text-sm text-gray-500">Anda sedang melihat room ini sebagai Administrator (Tidak bisa join).</p>
            </div>
        </div>

    
    <?php elseif($isStarted): ?>
        <div class="mb-12 w-full bg-gray-100 text-gray-500 font-bold py-5 rounded-2xl text-center border-2 border-gray-200 cursor-not-allowed shadow-inner flex flex-col items-center justify-center gap-2">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-lg">🚫 Room Closed (Waktu Habis)</span>
            <span class="text-sm font-normal">Pertandingan sudah dimulai atau selesai.</span>
        </div>

    
    <?php elseif($myStatus): ?>
        <div class="mb-12 p-6 rounded-2xl border-2 <?php echo e($myStatus == 'confirmed' ? 'bg-emerald-50 border-emerald-200' : 'bg-yellow-50 border-yellow-200'); ?>">
            <div class="flex items-center justify-center gap-4">
                <div class="p-3 rounded-full <?php echo e($myStatus == 'confirmed' ? 'bg-emerald-100 text-emerald-600' : 'bg-yellow-100 text-yellow-600'); ?>">
                    <?php if($myStatus == 'confirmed'): ?>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <?php else: ?>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?php endif; ?>
                </div>
                <div>
                    <h3 class="font-bold text-xl <?php echo e($myStatus == 'confirmed' ? 'text-emerald-800' : 'text-yellow-800'); ?>">
                        <?php echo e($myStatus == 'confirmed' ? 'Anda Terdaftar!' : 'Menunggu Konfirmasi'); ?>

                    </h3>
                    <p class="text-sm <?php echo e($myStatus == 'confirmed' ? 'text-emerald-600' : 'text-yellow-600'); ?>">
                        <?php echo e($myStatus == 'confirmed' ? 'Sampai jumpa di lapangan!' : 'Host sedang meninjau request Anda.'); ?>

                    </p>
                </div>
            </div>
        </div>

    
    <?php elseif($isHost): ?>
        <div class="mb-12">
            <a href="<?php echo e(route('rooms.edit', $room)); ?>" class="block w-full bg-gray-800 hover:bg-black text-white font-bold py-4 rounded-xl text-center transition shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Detail Room
            </a>
        </div>

    
    <?php else: ?>
        <form action="<?php echo e(route('rooms.join', $room)); ?>" method="POST" class="mb-12">
            <?php echo csrf_field(); ?>
            <?php if($isFull): ?>
                <button disabled type="button" class="w-full bg-red-50 text-red-400 font-bold py-4 rounded-xl cursor-not-allowed border-2 border-red-100">
                    Mohon Maaf, Slot Penuh
                </button>
            <?php else: ?>
                <button class="group w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-4 rounded-2xl shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex justify-center items-center gap-3">
                    <span class="text-lg">Gabung Room Ini Sekarang</span>
                    <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </button>
            <?php endif; ?>
        </form>
    <?php endif; ?>

    
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-black text-gray-800">Daftar Peserta</h3>
        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold"><?php echo e($room->participants->count()); ?> Orang</span>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
        <?php $__currentLoopData = $room->participants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $participant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="p-5 border-b border-gray-50 flex items-center justify-between last:border-0 hover:bg-gray-50 transition">
            <div class="flex items-center gap-4">
                <img src="<?php echo e($participant->user->avatar ? asset('storage/' . $participant->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($participant->user->name) . '&background=random&bold=true'); ?>" 
                     class="w-12 h-12 rounded-full border-2 border-white shadow-sm object-cover">
                
                <div>
                    <div class="flex items-center gap-2">
                        <p class="font-bold text-gray-900"><?php echo e($participant->user->name); ?></p>
                        <?php if($participant->user_id == $room->host_id): ?>
                            <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Host</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs text-gray-500">Bergabung <?php echo e($participant->created_at->diffForHumans()); ?></p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border <?php echo e($participant->status == 'confirmed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-yellow-50 text-yellow-600 border-yellow-100'); ?>">
                    <?php echo e(ucfirst($participant->status)); ?>

                </span>

                
                <?php if(auth()->id() == $room->host_id && $participant->status == 'requested'): ?>
                <form action="<?php echo e(route('participants.confirm', ['room' => $room->id, 'participant' => $participant->id])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-4 py-2 rounded-lg transition font-bold shadow-md transform active:scale-95">
                        Terima
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>


<script>
function copyCode() {
    var codeText = document.getElementById("roomCodeText").innerText;
    
    navigator.clipboard.writeText(codeText).then(function() {
        var toast = document.getElementById("toast");
        toast.classList.remove("translate-x-full");
        setTimeout(function(){
            toast.classList.add("translate-x-full");
        }, 3000);
    }, function(err) {
        alert('Gagal menyalin. Browser tidak support.');
    });
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/rooms/show.blade.php ENDPATH**/ ?>