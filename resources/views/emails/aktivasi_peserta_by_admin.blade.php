<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #006633;
            padding: 25px;
            text-align: center;
            color: #ffffff;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 1px;
        }

        .content {
            padding: 30px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            padding: 20px;
            background-color: #f4f4f4;
            border-top: 3px solid #006633;
        }

        .highlight {
            color: #006633;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            background-color: #cc9900;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>AKUN ANGGOTA BERHASIL DIBUAT</h2>
            <div style="font-size: 14px; margin-top: 5px;">MWC NU TUGU</div>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $userName }}</strong>,</p>

            <p>Akun portal MWC NU Tugu Anda telah <span class="highlight">dibuatkan oleh pihak Admin</span>.</p>
            <p>Status akun Anda saat ini sudah <span class="highlight">aktif</span> dan dapat langsung digunakan untuk masuk ke dalam sistem.</p>
            <p>Silakan gunakan email dan password yang telah didaftarkan oleh admin untuk mulai masuk ke portal.</p>

            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ url('/login') }}" class="btn">Masuk ke Website</a>
            </div>

            <p style="margin-top: 30px;">Terima kasih atas khidmat Anda.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} MWC NU Tugu. All rights reserved.
        </div>
    </div>
</body>

</html>
