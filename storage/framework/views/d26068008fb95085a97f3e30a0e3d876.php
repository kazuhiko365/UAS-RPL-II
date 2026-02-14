<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamu Diterima!</title>
    <style>
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
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .content {
            padding: 32px;
            text-align: center;
        }

        .success-icon {
            font-size: 40px;
            margin-bottom: 10px;
            display: block;
        }

        .card {
            background-color: #eff6ff;
            /* Blue 50 */
            border: 1px dashed #3b82f6;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }

        .card-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .label {
            font-weight: bold;
            width: 80px;
            color: #065f46;
        }

        .value {
            flex: 1;
            color: #1f2937;
        }

        .btn {
            display: inline-block;
            background-color: #111827;
            /* Gray 900 */
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>YESS! DITERIMA 🎉</h1>
        </div>

        <div class="content">
            <span class="success-icon">🙌</span>
            <h2 style="margin: 0 0 10px 0; color: #111827;">Halo <?php echo e($participant->user->name); ?>!</h2>
            <p style="margin-bottom: 20px;">Permintaan join kamu telah <strong>DIKONFIRMASI</strong> oleh Host. Siapkan
                sepatumu, kita main!</p>

            <div class="card">
                <div
                    style="text-align: center; font-weight: bold; margin-bottom: 15px; color: #1d4ed8; text-transform: uppercase; font-size: 12px;">
                    Detail Tiket Masuk
                </div>

                <div class="card-row">
                    <div class="label">Aktivitas</div>
                    <div class="value"><?php echo e($participant->room->title); ?></div>
                </div>
                <div class="card-row">
                    <div class="label">Waktu</div>
                    <div class="value"><?php echo e($participant->room->start_datetime->format('d M Y, H:i')); ?> WIB</div>
                </div>
                <div class="card-row">
                    <div class="label">Lokasi</div>
                    <div class="value"><?php echo e($participant->room->venue->name); ?></div>
                </div>
                <div class="card-row">
                    <div class="label">Biaya</div>
                    <div class="value">Rp <?php echo e(number_format($participant->room->cost_per_person, 0, ',', '.')); ?> / orang
                    </div>
                </div>
            </div>

            <p style="font-size: 14px; color: #6b7280; margin-bottom: 25px;">
                Jangan terlambat ya!
            </p>

        </div>

        <div class="footer">
            Sampai jumpa di lapangan!<br>
            &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?> Team.
        </div>
    </div>

</body>

</html><?php /**PATH D:\INFORMATIKA RASTRA\Smt 5\PTI\reclub-app\resources\views/emails/join_confirmed.blade.php ENDPATH**/ ?>