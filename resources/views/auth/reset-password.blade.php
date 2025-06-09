<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* ---------- BASE STYLE ---------- */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('{{ asset('images/background/flower.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .forget-password-modal {
            background-color: rgba(255, 255, 255, 0.9);
            width: 380px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeInUp 0.5s ease-in-out;
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #e965a7;
            margin-bottom: 20px;
        }

        .logo span {
            color: #000;
        }

        .forget-password-modal h2 {
            font-size: 24px;
            color: #080808;
            margin-bottom: 10px;
        }

        .forget-password-modal p {
            font-size: 14px;
            color: #090909;
            margin-bottom: 20px;
        }

        .forget-password-modal .gray-text {
            color: gray;
        }

        .forget-password-modal input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 6px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .forget-password-modal input[type="password"]:focus {
            border-color: #e965a7;
            outline: none;
        }

        .forget-password-modal button {
            width: 100%;
            padding: 12px;
            background-color: #e965a7;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            box-sizing: border-box;
            margin-top: 14px;
        }

        .forget-password-modal button:hover {
            background-color: #c84d85;
        }

        .forget-password-modal label {
            text-align: left;
            display: block;
            margin-top: 6px;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .error-message {
            color: red;
            font-size: 13px;
            background-color: #ffe6e6;
            padding: 6px 10px;
            border-left: 4px solid #ff4d4d;
            border-radius: 4px;
            margin-top: 10px;
        }

        /* ---------- ANIMATION ---------- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ---------- RESPONSIVE TABLET (≤768px) ---------- */
        @media (max-width: 768px) {
            .forget-password-modal {
                width: 90%;
                padding: 28px 20px;
            }

            .logo {
                font-size: 28px;
            }

            .forget-password-modal h2 {
                font-size: 20px;
                margin-bottom: 8px;
            }

            .forget-password-modal p,
            .forget-password-modal .gray-text {
                font-size: 13px;
                margin-bottom: 16px;
            }

            .forget-password-modal input[type="password"] {
                font-size: 14px;
                padding: 10px;
            }

            .forget-password-modal button {
                font-size: 14px;
                padding: 10px;
            }

            .error-message {
                font-size: 12px;
                padding: 6px;
            }
        }

        /* ---------- RESPONSIVE MOBILE (≤480px) ---------- */
        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .forget-password-modal {
                width: 100%;
                max-width: 340px;
                padding: 20px 16px;
            }

            .logo {
                font-size: 24px;
            }

            .forget-password-modal h2 {
                font-size: 18px;
            }

            .forget-password-modal p,
            .forget-password-modal .gray-text {
                font-size: 12px;
            }

            .forget-password-modal input[type="password"] {
                font-size: 13px;
                padding: 9px;
            }

            .forget-password-modal button {
                font-size: 13px;
                padding: 9px;
            }

            .error-message {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="forget-password-modal">
        <!-- Logo -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>

        <h2>Reset Password</h2>
        <p class="gray-text">Enter your new password below.</p>

        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            <!-- New Password Input -->
            <label for="password">New Password</label>
            <input type="password" name="password" required>

            <!-- Display error message for password -->
            @if ($errors->has('password'))
                <div class="error-message">{{ $errors->first('password') }}</div>
            @endif

            <!-- Confirm Password Input -->
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" required>

            <!-- Display error message for password confirmation -->
            @if ($errors->has('password_confirmation'))
                <div class="error-message">{{ $errors->first('password_confirmation') }}</div>
            @endif

            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
