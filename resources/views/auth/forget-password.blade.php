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
            background-color: #ffe2ee; /* Soft pink background */
        }

        .forgot-password-modal {
            background-color: #fff;
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
            padding: 15px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .forgot-password-modal input[type="email"]:focus,
        .forgot-password-modal input[type="text"]:focus,
        .forgot-password-modal input[type="password"]:focus {
            border-color: #e965a7;
            outline: none;
        }

        .forgot-password-modal button {
            width: 100%;
            padding: 15px;
            background-color: #e965a7;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
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
    </style>
</head>
<body>

    <div class="forgot-password-modal">
        <!-- Logo -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>
        
        <h2>Forgot Password</h2>
        
        <p>Enter your email address and we’ll send you a link to reset your password.</p>

        <!-- Form untuk reset password -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button type="submit">Reset Password</button>
        </form>

        <p><a href="{{ route('login') }}">Back to Login</a></p>
    </div>

</body>
</html>
