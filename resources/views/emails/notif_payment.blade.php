<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - ICPIP-HE 2026</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.8;
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
            border-top: 6px solid #065039;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .success-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            margin: 25px 0;
        }

        .certificate-text {
            font-size: 20px;
            font-weight: bold;
            color: #065039;
            margin: 10px 0;
            letter-spacing: 1px;
        }

        .btn {
            display: inline-block;
            padding: 14px 30px;
            background-color: #065039;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .info-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            font-size: 14px;
            margin: 20px 0;
            border: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0; color: #065039;">ICPIP-HE 2026</h2>
            <p style="margin: 5px 0; font-size: 14px; color: #666;">International Conference on Policy, Innovation, and
                Practice in Higher Education</p>
        </div>

        <p>Dear&nbsp;<strong>{{ $nama }}</strong>,</p>

        <p>Great news! We have successfully received your payment for the&nbsp;<strong>{{ $nama_conference }}</strong>.
            Your registration is now fully confirmed.</p>

        <div class="success-box">
            <div
                style="font-size: 12px; color: #166534; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">
                Certificate Number Generated</div>
            <div class="certificate-text">{{ $no_sertifikat }}</div>
            <p style="font-size: 13px; color: #666; margin: 0;">This number will be printed on your official conference
                certificate on your dashboard.</p>
        </div>

        <p>You can now access your submission details (if you as presenter), QR Code for attendance, download your certificate, and check for further updates regarding
            the conference informations through your participant dashboard.</p>

        <p>Here we also attach the invoice for your payment as a reference</p>

        <div style="text-align: center;">
            <a href="{{ $url }}" class="btn">GO TO DASHBOARD</a>
        </div>

        <div class="info-card">
            <strong>Next Steps:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #555;">
                <li>Waiting abstract review from reviewer (for presenters).</li>
                <li>Prepare your presentation materials (for presenters).</li>
                <li>Keep an eye on your email for the Zoom link/venue details.</li>
            </ul>
        </div>

        <p style="margin-top: 25px;">Should you have any questions, feel free to contact our support team.</p>

        <p>Best Regards,<br><strong>ICPIP-HE 2026 Committee</strong></p>

        <div class="footer">
            <p>This email was sent automatically by the ADAKSI system.<br>
                &copy; 2026 ICPIP-HE 2026. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
