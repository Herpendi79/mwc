<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICPIP-HE 2026 Account Activation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            border-top: 6px solid #0056b3;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 14px 30px;
            background-color: #0056b3;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 25px 0;
            transition: background 0.3s ease;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .highlight {
            color: #0056b3;
            font-weight: bold;
        }

        .link-text {
            font-size: 11px;
            color: #0056b3;
            word-break: break-all;
            line-height: 1.4;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0; color: #0056b3;">ICPIP-HE 2026</h2>
            <p style="margin: 5px 0; font-size: 14px; color: #666;">International Conference on Policy, Innovation, and Practice in Higher Education</p>
        </div>

        <p>Dear&nbsp;<strong>{{ $peserta->nama }}</strong>,</p>

        <p>Thank you for registering as a&nbsp;<span class="highlight">{{ $peserta->kategori }}</span>&nbsp;on the ADAKSI
            system for the&nbsp;<strong>ICPIP-HE 2026</strong>&nbsp;conference.</p>

        <p>To complete your registration and ensure your account is activated, please click the button below to verify
            your email address:</p>

        <div style="text-align: center;">
            <a href="{{ $url }}" class="btn">Verify My Email</a>
        </div>

        <p>Please note that this link is only valid for&nbsp;<strong>24 hours</strong>. If you do not perform the
            verification within this period, your data will be automatically removed from our system for security
            reasons.</p>

        <p style="margin-bottom: 10px;">If the button above does not work, please copy and paste the following link into
            your browser:</p>
        <p class="link-text">{{ $url }}</p>

        <p style="margin-top: 25px;">Best Regards,<br><strong>ICPIP-HE 2026 Committee</strong></p>

        <div class="footer">
            <p>This email was sent automatically by the ADAKSI system.<br>
                &copy; 2026 ICPIP-HE 2026. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
