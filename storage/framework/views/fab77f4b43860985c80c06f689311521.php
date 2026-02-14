
<?php $__env->startSection('content'); ?>
<div class="flex gap-6 flex-col md:flex-row">
    <div class="flex-1 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Sports List</h2>
        <ul>
            <?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="flex justify-between items-center border-b py-2">
                <span><?php echo e($s->name); ?></span>
                <form action="<?php echo e(route('admin.sports.destroy', $s)); ?>" method="POST" onsubmit="return confirm('Delete?');">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="text-red-500 text-sm">Delete</button>
                </form>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div class="mt-4"><?php echo e($sports->links()); ?></div>
    </div>

    <div class="w-full md:w-1/3 bg-white p-6 rounded shadow h-fit">
        <h2 class="text-xl font-bold mb-4">Add Sport</h2>
        <form action="<?php echo e(route('admin.sports.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-sm mb-1">Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm mb-1">Description</label>
                <textarea name="description" class="w-full border p-2 rounded"></textarea>
            </div>
            <button class="bg-blue-600 text-white w-full py-2 rounded">Save</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/admin/sports/index.blade.php ENDPATH**/ ?>