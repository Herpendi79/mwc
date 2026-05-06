<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your New Password - ICPIP-HE 2026</title>
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
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 20px; 
        }
        .password-box { 
            background: #f9f9f9; 
            border: 2px dashed #065039; 
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
            color: #065039; 
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0; color: #065039;">ICPIP-HE 2026</h2>
            <p style="margin: 5px 0; font-size: 14px; color: #666;">International Conference on Policy, Innovation, and Practice in Higher Education</p>
        </div>

        <p>Dear&nbsp;<strong>{{ $nama }}</strong>,</p>

        <p>We received a request to reset the password for your account associated with&nbsp;<strong>{{ $email }}</strong>. As requested, we have generated a new 6-digit temporary password for you:</p>

        <div class="password-box">
            <span class="password-text">{{ $newPassword }}</span>
        </div>

        <div class="warning">
            <strong>Security Reminder:</strong>&nbsp;For your safety, we strongly recommend that you log in immediately and change this temporary password through your profile settings.
        </div>

        <p>If you did not request a password reset, please ignore this email or contact our support team if you have any concerns.</p>

        <p style="margin-top: 25px;">Best Regards,<br><strong>ICPIP-HE 2026 Committee</strong></p>

        <div class="footer">
            <p>This email was sent automatically by the ADAKSI system.<br>
                &copy; 2026 ICPIP-HE 2026. All rights reserved.</p>
        </div>
    </div>
</body>
</html>