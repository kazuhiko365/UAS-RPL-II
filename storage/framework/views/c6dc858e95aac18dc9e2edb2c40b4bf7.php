
<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">User List</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="w-full bg-gray-100 text-left">
                    <th class="p-3">ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Phone</th>
                    <th class="p-3">Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b">
                    <td class="p-3"><?php echo e($u->id); ?></td>
                    <td class="p-3"><?php echo e($u->name); ?></td>
                    <td class="p-3"><?php echo e($u->email); ?></td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs <?php echo e($u->role == 'admin' ? 'bg-red-100 text-red-800' : 'bg-gray-100'); ?>">
                            <?php echo e($u->role); ?>

                        </span>
                    </td>
                    <td class="p-3"><?php echo e($u->phone ?? '-'); ?></td>
                    <td class="p-3"><?php echo e($u->created_at->format('d M Y')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($users->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Laravel\reclub-app\resources\views/admin/users.blade.php ENDPATH**/ ?>