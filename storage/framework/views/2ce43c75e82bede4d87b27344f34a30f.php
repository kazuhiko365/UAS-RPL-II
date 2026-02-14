

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900">Pengaturan Akun</h1>
            <p class="text-gray-500 mt-1">Perbarui foto, data diri, dan keamanan akun Anda.</p>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm flex items-center justify-between">
        <div class="flex items-center">
            <svg class="h-6 w-6 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="text-sm font-bold text-emerald-800"><?php echo e(session('success')); ?></p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm flex items-center justify-between">
        <div class="flex items-center">
            <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="text-sm font-bold text-red-800"><?php echo e(session('error')); ?></p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-emerald-500 to-green-600">
                    <h2 class="text-white font-bold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Edit Profil
                    </h2>
                </div>
                
                <div class="p-8">
                    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="flex flex-col sm:flex-row items-center gap-6 mb-8">
                            <div class="relative group">
                                <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-emerald-100 shadow-md">
                                    <?php if(Auth::user()->avatar): ?>
                                        <img id="preview-avatar" src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <img id="preview-avatar" src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(Auth::user()->name)); ?>&background=10b981&color=fff&size=128" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </div>
                                <label for="avatar-upload" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-full text-white font-bold text-xs">
                                    Ubah Foto
                                </label>
                            </div>
                            
                            <div class="flex-1 text-center sm:text-left">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil</label>
                                <input type="file" name="avatar" id="avatar-upload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition" accept="image/*" onchange="previewImage(event)">
                                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maks 2MB.</p>
                                <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <hr class="border-gray-100 mb-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="<?php echo e(old('name', Auth::user()->name)); ?>" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2.5 transition">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                                <input type="text" name="phone" value="<?php echo e(old('phone', Auth::user()->phone)); ?>" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2.5 transition" placeholder="08...">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Bio Singkat</label>
                            <textarea name="bio" rows="2" class="w-full border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-2.5 transition" placeholder="Contoh: Kiper Futsal, Main Santai, Cari Keringat"><?php echo e(old('bio', Auth::user()->bio)); ?></textarea>
                            <div class="flex justify-between mt-1">
                                <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                    <p class="text-red-500 text-xs"><?php echo e($message); ?></p> 
                                <?php else: ?>
                                    <span></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="text-xs text-gray-400">Maksimal 100 karakter.</p>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform active:scale-95 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-8">
            
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 bg-gray-50 border-b border-gray-100">
                    <h2 class="text-gray-800 font-bold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <?php echo e(!is_null(Auth::user()->password) ? 'Ganti Password' : 'Buat Password Baru'); ?>

                    </h2>
                </div>
                <div class="p-6">
                    
                    <?php if(is_null(Auth::user()->password)): ?>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-blue-700 leading-relaxed">
                                        Anda login via <strong>Google</strong>. Buat password di bawah ini agar Anda bisa login manual (menggunakan Email & Password).
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('profile.password')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <?php if(!is_null(Auth::user()->password)): ?>
                        <div class="mb-4 relative">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password Lama</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password" class="w-full border-gray-300 rounded-xl text-sm px-4 py-2.5 focus:ring-emerald-500 focus:border-emerald-500 pr-10 transition">
                                <button type="button" onclick="togglePassword('current_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php endif; ?>

                        <div class="mb-4 relative">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-xl text-sm px-4 py-2.5 focus:ring-emerald-500 focus:border-emerald-500 pr-10 transition">
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-6 relative">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ulangi Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-gray-300 rounded-xl text-sm px-4 py-2.5 focus:ring-emerald-500 focus:border-emerald-500 pr-10 transition">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 rounded-xl transition text-sm shadow-md transform active:scale-95 flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <?php echo e(!is_null(Auth::user()->password) ? 'Update Password' : 'Simpan Password'); ?>

                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 shadow-sm">
                <h3 class="text-blue-800 font-bold mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Info Akun
                </h3>
                <div class="space-y-2 text-sm text-blue-700">
                    <p>Status: <span class="font-bold uppercase bg-blue-200 px-2 py-0.5 rounded text-xs"><?php echo e(Auth::user()->role); ?></span></p>
                    <p>Email: <span class="font-medium"><?php echo e(Auth::user()->email); ?></span></p>
                    <p>Bergabung: <span class="font-medium"><?php echo e(Auth::user()->created_at->format('d M Y')); ?></span></p>
                </div>
            </div>

            <?php if(Auth::user()->role !== 'admin'): ?>
            <div class="bg-red-50 rounded-2xl p-6 border border-red-100 shadow-sm mt-8">
                <div class="flex items-start gap-3">
                    <div class="bg-red-100 p-2 rounded-full text-red-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-red-800 font-bold text-lg">Hapus Akun</h3>
                        <p class="text-sm text-red-600 mt-1 mb-4 leading-relaxed">
                            Tindakan ini tidak dapat dibatalkan. Semua data room, chat, dan riwayat mabar Anda akan dihapus permanen.
                        </p>
                        
                        <form action="<?php echo e(route('profile.destroy')); ?>" method="POST" onsubmit="return confirm('PERINGATAN KERAS:\n\nApakah Anda yakin ingin menghapus akun ini secara PERMANEN?\nSemua data Anda akan hilang dan tidak bisa dikembalikan.\n\nKlik OK untuk melanjutkan.')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Ya, Hapus Akun Saya
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
// Fungsi Preview Foto Profil
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview-avatar');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Fungsi Show/Hide Password
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Laravel\reclub-app\resources\views/profile/edit.blade.php ENDPATH**/ ?>