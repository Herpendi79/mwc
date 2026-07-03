<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Paper Submission Result - ICPIP-HE 2026</title>
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
            border-top: 6px solid {{ $status == 'accepted' ? '#10b981' : '#f59e0b' }};
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
            margin: 15px 0;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            {{ $status == 'accepted' ? 'background: #ecfdf5; color: #059669;' : 'background: #fffbeb; color: #d97706;' }}
        }

        .comment-box {
            background: #f9f9f9;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            font-style: italic;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0; color: #0056b3;">ICPIP-HE 2026</h2>
            <p style="margin: 5px 0; font-size: 14px; color: #666;">International Conference on Policy, Innovation, and
                Practice in Higher Education</p>
        </div>

        <p>Dear &nbsp;<strong>{{ $nama }}</strong>,</p>

        <div class="status-badge">
            {{ $status == 'accepted' ? 'Accepted' : 'Revision Required' }}
        </div>

        @if ($status == 'accepted')
            {{-- KONTEN JIKA ACCEPTED --}}
            <p>Congratulations! After a thorough review process, we are pleased to inform you that your full paper
                submission for &nbsp;<strong>ICPIP-HE 2026</strong>&nbsp; has been &nbsp;<span
                    style="color: #059669; font-weight: bold;">Accepted</span>.</p>

            <p>Please wait the next information from us or publication management </p>
        @else
            {{-- KONTEN JIKA REVISION --}}
            <p>Thank you for your submission to &nbsp;<strong>ICPIP-HE 2026</strong>. After reviewing your full paper, the
                reviewer has determined that &nbsp;<span style="color: #d97706; font-weight: bold;">Revision is
                    Required</span>&nbsp; before it can be accepted.</p>

            <p><strong>Reviewer's Feedback:</strong></p>
            <div class="comment-box">
                "{{ $comment }}"
            </div>

            <p><strong>Please go to your dashboard to view the revision details.</strong></p>

            <p>Please revise your full paper based on the comments and &nbsp;<strong>re-upload</strong>&nbsp; the document
                through your presenter dashboard.</p>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="btn">Go to Dashboard</a>
            </div>
        @endif

        <p style="margin-top: 25px;">Best Regards,<br><strong>ICPIP-HE 2026 Committee</strong></p>

        <div class="footer">
            <p>This email was sent automatically by the ADAKSI system.<br>
                &copy; 2026 ICPIP-HE 2026. All rights reserved.</p>
        </div>
    </div>
</body>

</html>

