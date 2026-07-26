<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
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
            text-transform: uppercase;
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

        .box-info {
            background-color: #f0f7f4;
            padding: 20px;
            border-left: 4px solid #006633;
            list-style: none;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Manajemen Opini</h2>
        </div>

        <div class="content">
            <p>Yth. <strong>{{ $penulis }}</strong>,</p>

            <p>Alhamdulillah, kami telah menerima artikel opini yang Anda sampaikan melalui kanal Opini MWC NU Tugu.</p>

            <p>Detail Opini:</p>
            <ul class="box-info">
                <li><strong>Judul:</strong> {{ $judul }}</li>
                <li><strong>Status:</strong> Dalam Tahap Kajian</li>
            </ul>

            <p>Saat ini, tim redaksi kami sedang meninjau artikel Anda. Terima kasih atas partisipasi dan kontribusi
                pemikiran Anda dalam memperkaya khazanah literasi organisasi.</p>

            <p>Semoga menjadi kebaikan dan amal jariyah bagi kita semua.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} MWC NU Tugu. Semua hak dilindungi.
        </div>
    </div>
</body>

</html>
