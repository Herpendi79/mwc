<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #f4f4f4;
            padding-bottom: 10px;
        }

        .content {
            padding: 20px 0;
        }

        .footer {
            font-size: 11px;
            text-align: center;
            color: #777;
            margin-top: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .success {
            background-color: #dcfce7;
            color: #166534;
        }

        .danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .reason-box {
            background-color: #f9fafb;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Payment Notification</h2>
            <p>{{ $nama_conference }}</p>
        </div>
        <div class="content">
            <p>Dear &nbsp;<strong>{{ $nama }}</strong>,</p>

            <p>This is a notification regarding your payment status for &nbsp;<strong>{{ $nama_conference }}</strong>.
            </p>

            <p>Status:
                <span class="status-badge {{ $status === 'success' ? 'success' : 'danger' }}">
                    {{ $status === 'success' ? 'Verified' : 'Rejected' }}
                </span>
            </p>

            @if ($status === 'success')
                <p>Congratulations! Your payment proof has been verified. {{ $keterangan_tambahan }}</p>
            @else
                <p>We are sorry to inform you that your payment proof was rejected.</p>
                <div class="reason-box">
                    <strong>Reason for rejection:</strong><br>
                    {{ $comment ?? 'No specific reason provided.' }}
                </div>
                <p>Please log in to your account and re-register on the Conference.</p>
            @endif

            <p>Best regards,<br>Organizing Committee of {{ $nama_conference }}</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $nama_conference }}. All rights reserved.<br>
            This is an automated system email, please do not reply.
        </div>
    </div>
</body>

</html>
