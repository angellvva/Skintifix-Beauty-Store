<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 30px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        h2 {
            color: #e965a7;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #e965a7;
            margin: 20px 0;
        }
        .footer {
            font-size: 12px;
            color: gray;
            margin-top: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Skintifix Beauty Store</h2>
        <p>Use this code to reset your password:</p>
        <div class="otp-code">{{ $otp }}</div>
        <p>This code will expire in 10 minutes.</p>

        <div class="footer">
            If you did not request a password reset, please ignore this email.
        </div>
    </div>
</body>
</html>