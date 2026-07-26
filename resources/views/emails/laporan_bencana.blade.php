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
            background-color: #b91c1c;
            /* Merah untuk identitas tanggap bencana */
            padding: 25px;
            text-align: center;
            color: #ffffff;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
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
            border-top: 3px solid #b91c1c;
        }

        .box-info {
            background-color: #fef2f2;
            padding: 20px;
            border-left: 4px solid #b91c1c;
            list-style: none;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Laporan Bencana Diterima</h2>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $data['name'] }}</strong>,</p>
            <p>Terima kasih banyak atas laporan bencana yang telah Anda sampaikan. Laporan Anda telah kami terima di
                sistem.</p>

            <p>Detail Laporan:</p>
            <ul class="box-info">
                <li><strong>Jenis Bencana:</strong> {{ $data['jenis_bencana'] }}</li>
                <li><strong>Lokasi:</strong> {{ $data['lokasi'] }}</li>
                <li><strong>Korban:</strong> {{ $data['jml_korban'] }} orang</li>
                <li><strong>Status:</strong> Menunggu Verifikasi Tim</li>
            </ul>

            <p>Laporan Anda sangat berharga bagi kami. Semoga dengan langkah awal ini, penanganan dini dapat dilakukan
                dengan lebih baik dan banyak korban yang terselamatkan.</p>

            <p style="font-style: italic; color: #555;">"Semoga Allah segera mengangkat musibah ini dari tanah air kita."
            </p>

            <p>Salam takzim,<br><strong>Tim Tanggap Bencana</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} MWC NU Tugu. Semua hak dilindungi.
        </div>
    </div>
</body>

</html>
