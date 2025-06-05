<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
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

        .forget-password-modal input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 6px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .forget-password-modal input[type="text"]:focus {
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

        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #e965a7;
            margin-bottom: 20px;
        }

        .forget-password-modal label {
            text-align: left;
            display: block;
            margin-top: 6px;
        }

        .forget-password-modal .gray-text {
            color: gray;
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
        /* Gaya countdown timer */
        .timer {
            font-size: 16px;
            color: red;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="forget-password-modal">
        <!-- Logo -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>

        <h2>Forget Password</h2>
        <p class="gray-text">Enter your email address and verify your OTP.</p>

        <form method="POST" action="{{ route('verify.otp') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">

            <label for="otp">Enter OTP</label>
            <input type="text" name="otp" required placeholder="Enter OTP">
            <div id="timer" class="timer"></div>
            <button type="submit">Verify</button>
        </form>

        <!-- Back to Login Button -->
        <form action="{{ route('login') }}" method="GET">
            <button type="submit" style="background-color: #f1f1f1; color: #333; border: 1px solid #ddd; margin-top: 20px;">
                Back to Login
            </button>
        </form>
    </div>
    <script>
        // Timer countdown selama 1 menit (60 detik)
        let countdown = 60; // Set waktu countdown dalam detik
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            if (countdown <= 0) {
                timerElement.innerHTML = 'OTP Expired!';
                clearInterval(timerInterval); // Menghentikan interval ketika waktu habis
            } else {
                timerElement.innerHTML = `Time left: ${countdown} seconds`;
            }
        }

        // Menjalankan countdown setiap detik
        const timerInterval = setInterval(function () {
            countdown--;
            updateTimer();
        }, 1000); // Update setiap detik
    </script>
</body>

</html>
