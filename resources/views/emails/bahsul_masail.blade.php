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
            <h2>Bahtsul Masail</h2>
        </div>

        <div class="content">
            <p>Yth. <strong>{{ $data['name'] }}</strong>,</p>

            <p>Alhamdulillah, kami telah menerima pertanyaan yang Anda sampaikan melalui kanal Bahtsul Masail.</p>

            <p>Detail Pertanyaan:</p>
            <ul class="box-info">
                <li><strong>Judul/Topik:</strong> {{ $data['judul'] }}</li>
                <li><strong>Status:</strong> Sedang dalam pengkajian</li>
            </ul>

            <p>Besar harapan kami agar pertanyaan ini dapat menjawab fenomena yang terjadi di tengah umat saat ini. Terima kasih atas kontribusi Anda dalam menjaga keilmuan.</p>

            <p>Semoga menjadi kebaikan dan amal jariyah bagi kita semua.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} MWC NU Tugu. Semua hak dilindungi.
        </div>
    </div>
</body>

</html>
