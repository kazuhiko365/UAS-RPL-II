
<?php $__env->startSection('content'); ?>
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Activity Logs</h2>
        
        <form method="GET" class="flex gap-2">
            <select name="action" class="border p-2 rounded text-sm">
                <option value="">All Actions</option>
                <option value="room_created" <?php echo e(request('action')=='room_created'?'selected':''); ?>>Room Created</option>
                <option value="join_requested" <?php echo e(request('action')=='join_requested'?'selected':''); ?>>Join Requested</option>
                <option value="join_confirmed" <?php echo e(request('action')=='join_confirmed'?'selected':''); ?>>Join Confirmed</option>
                <option value="login_email" <?php echo e(request('action')=='login_email'?'selected':''); ?>>Login</option>
            </select>
            <button class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Filter</button>
        </form>
    </div>

    <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Time</th>
                <th class="p-3 text-left">Actor</th>
                <th class="p-3 text-left">Action</th>
                <th class="p-3 text-left">Subject ID</th>
                <th class="p-3 text-left">Meta</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-b">
                <td class="p-3"><?php echo e($log->created_at->format('Y-m-d H:i')); ?></td>
                <td class="p-3 font-medium"><?php echo e($log->actor->name ?? 'System'); ?></td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded bg-blue-50 text-blue-700"><?php echo e($log->action); ?></span>
                </td>
                <td class="p-3"><?php echo e($log->subject_id ?? '-'); ?></td>
                <td class="p-3 text-gray-500">
                    <?php if($log->meta): ?>
                        <pre class="text-xs"><?php echo e(json_encode($log->meta)); ?></pre>
                    <?php else: ?> - <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="mt-4"><?php echo e($logs->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/admin/activity.blade.php ENDPATH**/ ?>