<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Baru Anda - MWC NU TUGU</title>
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

        .header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #d4ebd4;
        }

        .content {
            padding: 30px;
        }

        .password-box {
            background-color: #f0f7f4;
            border: 2px dashed #006633;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }

        .password-text {
            font-size: 32px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            letter-spacing: 8px;
            color: #006633;
        }

        .box-info {
            background-color: #f0f7f4;
            padding: 15px 20px;
            border-left: 4px solid #006633;
            list-style: none;
            margin: 20px 0;
            font-size: 14px;
            color: #555;
            border-radius: 0 8px 8px 0;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            padding: 20px;
            background-color: #f4f4f4;
            border-top: 3px solid #006633;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>MWC NU TUGU</h2>
            <p>Majelis Wakil Cabang Nahdlatul Ulama Tugu</p>
        </div>

        <div class="content">
            <p>Yth. <strong>{{ $nama }}</strong>,</p>

            <p>Kami menerima permintaan untuk menyetel ulang kata sandi pada akun Anda yang terdaftar dengan email <strong>{{ $email }}</strong>. Sesuai permintaan Anda, berikut adalah kata sandi sementara yang baru:</p>

            <div class="password-box">
                <span class="password-text">{{ $newPassword }}</span>
            </div>

            <div class="box-info">
                <strong>Pengingat Keamanan:</strong> Demi keamanan akun Anda, sangat disarankan untuk segera masuk (*login*) dan mengubah kata sandi sementara ini melalui menu pengaturan profil.
            </div>

            <p>Jika Anda tidak merasa melakukan permintaan reset kata sandi, abaikan saja email ini atau hubungi tim dukungan kami jika Anda memiliki kendala.</p>

            <p style="margin-top: 25px;">Hormat kami,<br><strong>Tim Admin MWC NU Tugu</strong></p>
        </div>

        <div class="footer">
            <p>Email ini dikirimkan secara otomatis oleh sistem.<br>
            &copy; {{ date('Y') }} MWC NU Tugu. Semua hak dilindungi.</p>
        </div>
    </div>
</body>

</html>
