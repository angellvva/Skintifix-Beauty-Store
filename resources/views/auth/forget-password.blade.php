<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
            /* Update with the correct image path */
            background-size: cover;
            /* Ensures the image covers the entire background */
            background-position: center;
            /* Center the image */
            background-repeat: no-repeat;
            /* Prevents the image from repeating */
        }

        .forgot-password-modal {
            background-color: rgba(255, 255, 255, 0.9);
            width: 380px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .forgot-password-modal h2 {
            font-size: 24px;
            color: #080808;
            margin-bottom: 10px;
        }

        .forgot-password-modal p {
            font-size: 14px;
            color: #090909;
            margin-bottom: 20px;
        }

        .forgot-password-modal input[type="email"],
        .forgot-password-modal input[type="text"],
        .forgot-password-modal input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 6px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .forgot-password-modal input[type="email"]:focus,
        .forgot-password-modal input[type="text"]:focus,
        .forgot-password-modal input[type="password"]:focus {
            border-color: #e965a7;
            outline: none;
        }

        .forgot-password-modal button {
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

        .forgot-password-modal button:hover {
            background-color: #c84d85;
        }

        .forgot-password-modal p a {
            color: #e965a7;
            text-decoration: none;
        }

        .forgot-password-modal p a:hover {
            text-decoration: underline;
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #e965a7;
            margin-bottom: 20px;
        }

        .forgot-password-modal label {
            text-align: left;
            display: block;
            margin-top: 6px;
        }

        .forgot-password-modal .gray-text {
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
    </style>
</head>

<body>

    <div class="forgot-password-modal">
        <!-- Logo -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>

        <h2>Forgot Password</h2>

        <p class="gray-text">Enter your email address and we’ll send you a link to reset your password.</p>

        <!-- Form untuk reset password -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="name@example.com" required>
            @if ($errors->has('email'))
                <div class="error-message">{{ $errors->first('email') }}</div>
            @endif

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="" required>
             @if ($errors->has('password'))
                <div class="error-message">{{ $errors->first('password') }}</div>
            @endif

            <label for="confirm-password">Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="" required>
            @if ($errors->has('password_confirmation'))
                <div class="error-message">{{ $errors->first('password_confirmation') }}</div>
            @endif
         
            <button type="submit">Reset Password</button>
        </form>

        <p><a href="{{ route('login') }}"><b>Back to Login</b></a></p>
    </div>

</body>
</html>
