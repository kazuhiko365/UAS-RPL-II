<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white max-w-md w-full rounded-3xl shadow-2xl overflow-hidden">
        <div class="bg-emerald-500 p-8 text-center">
            <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-white text-2xl font-black tracking-tight">BERHASIL!</h1>
            <p class="text-emerald-100 text-sm mt-1">Peserta telah resmi bergabung.</p>
        </div>

        <div class="p-8">
            <div class="text-center mb-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">STATUS PESERTA</p>
                <span class="bg-emerald-100 text-emerald-700 px-4 py-1 rounded-full text-sm font-bold border border-emerald-200">
                    DITERIMA / CONFIRMED
                </span>
            </div>

            <div class="space-y-4 border-t border-gray-100 pt-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">👤 Nama Peserta</span>
                    <span class="font-bold text-gray-800"><?php echo e($participant->user->name); ?></span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">🏆 Room/Judul</span>
                    <span class="font-bold text-gray-800 text-right truncate w-40"><?php echo e($participant->room->title); ?></span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">⚽ Cabang Olahraga</span>
                    <span class="font-bold text-gray-800"><?php echo e($participant->room->sport->name); ?></span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">📅 Jadwal Main</span>
                    <span class="font-bold text-gray-800 text-right">
                        <?php echo e($participant->room->start_datetime->format('d M Y')); ?><br>
                        <span class="text-xs text-gray-400">Pukul <?php echo e($participant->room->start_datetime->format('H:i')); ?> WIB</span>
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">👑 Host Room</span>
                    <span class="font-bold text-gray-800"><?php echo e($participant->room->host->name); ?></span>
                </div>
            </div>

            <div class="mt-8 space-y-3">
                <a href="<?php echo e(route('login')); ?>" class="block w-full bg-gray-900 text-white text-center py-3 rounded-xl font-bold shadow-lg hover:bg-black transition transform active:scale-95">
                    Masuk ke Aplikasi
                </a>
            </div>
        </div>
        
        <div class="bg-gray-50 p-4 text-center text-xs text-gray-400">
            Halaman ini valid & aman (Signed by System).
        </div>
    </div>

</body>
</html><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/pages/confirmation_success.blade.php ENDPATH**/ ?>