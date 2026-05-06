<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Instruction - ICPIP-HE 2026</title>
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
            border-top: 6px solid #065039;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .invoice-box {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .total-amount {
            font-size: 28px;
            font-weight: bold;
            color: #065039;
            text-align: center;
            margin: 10px 0;
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

        .warning {
            background-color: #fff4e5;
            border-left: 4px solid #ffa117;
            padding: 15px;
            font-size: 14px;
            color: #664d03;
            margin: 20px 0;
        }

        .link-text {
            font-size: 11px;
            color: #065039;
            word-break: break-all;
            line-height: 1.4;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #eee;
            margin-top: 10px;
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

        <p>Thank you for submitting your abstract to the&nbsp;<strong>{{ $nama_conference }}</strong>. To complete your
            submission process, please proceed with the payment for the following registration fee:</p>

        <div class="invoice-box">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td style="padding-bottom: 10px; font-size: 14px; color: #666;">Order ID:</td>
                    <td style="padding-bottom: 10px; font-size: 14px; text-align: right;">
                        <strong>{{ $order_id }}</strong></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 10px; font-size: 14px; color: #666;">Description:</td>
                    <td style="padding-bottom: 10px; font-size: 14px; text-align: right;">Conference Registration Fee
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 15px; border-top: 1px dashed #ccc; text-align: center;">
                        <div style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 1px;">Total
                            Amount</div>
                        <div class="total-amount">IDR {{ number_format($biaya, 0, ',', '.') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="text-align: center;">
            <a href="{{ $urlPembayaran }}" class="btn">PAY NOW</a>
        </div>

        <div class="warning">
            <strong>Payment Deadline:</strong>&nbsp;Please complete your payment
            before&nbsp;<strong>{{ $expiry }}</strong>. If the payment is not received by this time, your
            submission may be automatically cancelled.
        </div>

        <p style="margin-bottom: 10px;">If the button above does not work, please copy and paste the following link into
            your browser:</p>
        <p class="link-text">{{ $urlPembayaran }}</p>

        <p style="margin-top: 25px;">Best Regards,<br><strong>ICPIP-HE 2026 Committee</strong></p>

        <div class="footer">
            <p>This email was sent automatically by the ADAKSI system.<br>
                &copy; 2026 ICPIP-HE 2026. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
