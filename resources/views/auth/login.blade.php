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
            background-image: url('{{ asset('images/background/flower.jpg') }}'); /* Update with the correct image path */
            background-size: cover;  /* Ensures the image covers the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevents the image from repeating */
        }

        .login-modal {
            background-color: rgba(255, 255, 255, 0.9); 
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
            padding: 12px;
            margin: 6px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .login-modal input[type="text"]:focus,
        .login-modal input[type="password"]:focus {
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

        .login-modal label {
            text-align: left;
            display: block;
            margin-top: 6px;
        }

        .login-modal .gray-text {
            color: gray;
        }
    </style>
</head>
<body>

    <div class="login-modal">
        <!-- Icon for Account Login / Signup -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>
        <h2>Account Sign In</h2>
        <p class="gray-text">Welcome back! Please sign in below to access your account and view your previous order history and earned points.</p>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="name@example.com" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="" required>

            <button type="submit">Sign In</button>
        </form>

        <p><a href="{{ route('forget-password') }}">Forgot your password?</a></p>
        

        <p class="gray-text" style="margin-top: 20px; margin-bottom: 14px;">New to Skintifix Beauty Store? <a href="{{ route('register') }}"><b>Create your account</b></a> <br>and start earning rewards today!</br></p>
    </div>

</body>
</html>
