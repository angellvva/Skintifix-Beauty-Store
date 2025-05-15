<!-- views/login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Account Sign In</title>
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

        .login-modal {
            background-color: #fff;
            width: 380px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-modal img {
            width: 50px;
            height: 50px;
            margin-bottom: 20px;
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

        .login-modal input[type="text"],
        .login-modal input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .login-modal input[type="text"]:focus,
        .login-modal input[type="password"]:focus {
            border-color: #e965a7;
            outline: none;
        }

        .login-modal button {
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

        .login-modal button:hover {
            background-color: #e965a7;
        }

        .login-modal p a {
            color: #e965a7;
            text-decoration: none;
        }

        .login-modal p a:hover {
            text-decoration: underline;
        }

       .logo {
            font-size: 36px;
            font-weight: bold;
            color: #e965a7; /* Pink color for Skintifix */
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="login-modal">
        <!-- Icon for Account Login / Signup -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>
        <h2>Account Sign In</h2>
        <p>New to Skintifix Beauty Store? <a href="{{ route('register') }}">Create your account</a> and start earning rewards today!</p>
        <p>Welcome back! Please sign in below to access your account and view your previous order history and earned points.</p>

        <form action="{{ route('home') }}" method="GET">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">SIGN IN</button>
        </form>

        <p><a href="{{ route('forget-password') }}">Forgot your password?</a></p>
    </div>

</body>
</html>
