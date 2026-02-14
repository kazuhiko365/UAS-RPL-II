<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Join Room</title>
    <style>
        /* CSS Inline Sederhana untuk Email */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            color: #374151;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #3b82f6;
            /* Blue 500 */
            padding: 24px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }

        .content {
            padding: 32px;
        }

        .info-box {
            background-color: #eff6ff;
            /* Blue 50 */
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-item {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .btn {
            display: block;
            width: fit-content;
            margin: 0 auto;
            background-color: #111827;
            /* Gray 900 */
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        .link-secondary {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>SportsPlay Notification</h1>
        </div>

        <div class="content">
            <h2 style="margin-top: 0; color: #111827;">Halo Host! 👋</h2>
            <p>Ada peserta baru yang ingin bergabung untuk mabar. Mohon tinjau detail berikut:</p>

            <div class="info-box">
                <div class="info-item">
                    <strong>👤 Peserta:</strong> <?php echo e($participant->user->name); ?>

                </div>
                <div class="info-item">
                    <strong>🏆 Room:</strong> <?php echo e($participant->room->title); ?>

                </div>
                <div class="info-item">
                    <strong>📅 Jadwal:</strong> <?php echo e($participant->room->start_datetime->format('d M Y, H:i')); ?> WIB
                </div>
            </div>

            <p style="text-align: center; margin-bottom: 24px;">Klik tombol di bawah untuk langsung
                <strong>MENERIMA</strong> peserta ini:
            </p>

            <a href="<?php echo e($urlConfirm); ?>" class="btn">
                ✅ Terima Peserta Ini
            </a>

            <p style="margin-top: 30px; font-size: 14px; text-align: center;">
                Ingin cek profilnya dulu?
                <a href="<?php echo e(route('rooms.show', $participant->room->id)); ?>" class="link-secondary">Lihat Detail Room</a>
            </p>
        </div>

        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.<br>
            Email ini dikirim secara otomatis.
        </div>
    </div>

</body>

</html><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/emails/join_request.blade.php ENDPATH**/ ?>