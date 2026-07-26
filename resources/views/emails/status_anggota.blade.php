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
            margin-top: 10px;
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
            <h2>PEMBERITAHUAN KEANGGOTAAN</h2>
            <div style="font-size: 14px; margin-top: 5px;">MWC NU TUGU</div>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $userName }}</strong>,</p>

            @if ($action == 'setuju')
                <p>Alhamdulillah, pendaftaran Anda telah <span class="highlight">disetujui</span>.</p>
                <p>Status keanggotaan Anda sekarang adalah <strong>Aktif</strong>. Semoga kehadiran Anda membawa manfaat
                    bagi umat dan organisasi.</p>
                <div style="text-align: center; margin: 20px 0;">
                    <a href="{{ url('/') }}" class="btn">Masuk ke Dashboard</a>
                </div>
            @elseif($action == 'tolak')
                <p>Kami memohon maaf, pendaftaran Anda <span style="color: #c00;">tidak dapat disetujui</span> untuk saat
                    ini.</p>
                <p>Data keanggotaan Anda telah dihapus dari sistem sesuai dengan kebijakan administrasi kami.</p>
            @elseif($action == 'aktivasi')
                <p>Kabar gembira! Status keanggotaan Anda telah <span class="highlight">diaktifkan kembali</span>.</p>
                <p>Anda kini dapat kembali beraktivitas dan mengakses fitur layanan anggota.</p>
            @endif

            <p style="margin-top: 30px;">Terima kasih atas khidmat Anda.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} MWC NU Tugu. All rights reserved.
        </div>
    </div>
</body>

</html>
