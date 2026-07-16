<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .wrapper { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        .header { background: #007b9a; padding: 32px; text-align: center; }
        .header img { height: 50px; }
        .header h1 { color: #fff; margin: 12px 0 0; font-size: 20px; }
        .body { padding: 36px 40px; }
        .body p { color: #444; font-size: 15px; line-height: 1.6; }
        .otp-box { background: #f0f9fb; border: 2px dashed #007b9a; border-radius: 8px; text-align: center; padding: 24px; margin: 28px 0; }
        .otp-box .otp { font-size: 40px; font-weight: bold; letter-spacing: 10px; color: #007b9a; }
        .otp-box small { color: #888; font-size: 13px; }
        .footer { background: #f9f9f9; padding: 20px 40px; text-align: center; color: #999; font-size: 12px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>The Sprout Academy</h1>
            <p style="color:#cef0f8; margin:4px 0 0; font-size:14px;">Employee Portal</p>
        </div>
        <div class="body">
            <p>Hi there,</p>
            <p>You requested to create an Employee Portal account. Use the code below to verify your email address:</p>
            <div class="otp-box">
                <div class="otp">{{ $otp }}</div>
                <small>This code expires in <strong>10 minutes</strong></small>
            </div>
            <p>If you did not request this, you can safely ignore this email.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} The Sprout Academy. All rights reserved.
        </div>
    </div>
</body>
</html>
