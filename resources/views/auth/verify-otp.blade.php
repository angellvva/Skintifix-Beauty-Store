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

        .login-modal {
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
            margin-bottom: 10px;
        }

        .logo span {
            color: #000;
        }

        .login-modal h2 {
            font-size: 24px;
            color: #080808;
            margin-bottom: 10px;
        }

        .login-modal p {
            font-size: 14px;
            color: #090909;
            margin-bottom: 20px;
        }

        .gray-text {
            color: gray;
        }

        .login-modal input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 6px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .login-modal input[type="text"]:focus {
            border-color: #e965a7;
            outline: none;
        }

        .login-modal button {
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

        .login-modal button:hover {
            background-color: #c84d85;
        }

        .login-modal label {
            text-align: left;
            display: block;
            margin-top: 6px;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .login-modal p a {
            color: #e965a7;
            text-decoration: none;
        }

        .login-modal p a:hover {
            text-decoration: underline;
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

        .back-to-login {
            margin-top: 15px;
        }

        .back-to-login a {
            color: #e965a7;
            text-decoration: none;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }

        .create-account-text {
            margin-top: 20px;
            margin-bottom: 14px;
        }

        /* Timer Styles */
        .timer {
            font-size: 16px;
            color: #e965a7;
            margin-top: 20px;
            font-weight: bold;
        }

        .otp-expired {
            color: red;
            font-weight: bold;
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
            .login-modal {
                width: 90%;
                padding: 28px 20px;
            }

            .logo {
                font-size: 28px;
            }

            .login-modal h2 {
                font-size: 20px;
                margin-bottom: 8px;
            }

            .login-modal p,
            .gray-text {
                font-size: 13px;
                margin-bottom: 16px;
            }

            .login-modal input[type="text"] {
                font-size: 14px;
                padding: 10px;
            }

            .login-modal button {
                font-size: 14px;
                padding: 10px;
            }

            .timer {
                font-size: 14px;
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

            .login-modal {
                width: 100%;
                max-width: 340px;
                padding: 20px 16px;
            }

            .logo {
                font-size: 24px;
            }

            .login-modal h2 {
                font-size: 18px;
            }

            .login-modal p,
            .gray-text {
                font-size: 12px;
            }

            .login-modal input[type="text"] {
                font-size: 13px;
                padding: 9px;
            }

            .login-modal button {
                font-size: 13px;
                padding: 9px;
            }

            .timer {
                font-size: 13px;
            }

            .error-message {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="login-modal">
        <!-- Logo -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>

        <h2>Forget Password</h2>
        <p class="gray-text">Enter your email address and verify your OTP.</p>

        <form method="POST" action="{{ route('verify.otp') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            <label for="otp">Enter OTP</label>
            <input type="text" name="otp" required placeholder="Enter OTP">  

            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <div id="timer" class="timer"></div>
            <button type="submit">Verify</button>
        </form>

        <p class="gray-text create-account-text">Didn't receive OTP? <a href="{{ route('resend.otp') }}"><b>Resend OTP</b></a></p>
        <div class="back-to-login">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
    <script>
        // Timer countdown selama 1 menit (60 detik)
        let timeLeft = 60; // Set waktu countdown dalam detik
        const timerElement = document.getElementById('timer');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            if (timeLeft <= 0) {
                timerElement.innerHTML = 'OTP Expired!';
                timerElement.className = 'timer otp-expired';
                clearInterval(timerInterval);
            } else {
                timerElement.innerHTML = `Time left: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                timeLeft--;
            }
        }
        
        // Menjalankan countdown setiap detik
        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer(); // Panggil sekali untuk inisialisasi
    </script>
</body>
</html>