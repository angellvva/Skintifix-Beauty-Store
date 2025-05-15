<!-- views/login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login - Innisfree Clone</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            height: 100vh;
        }

        .left-side {
            flex: 1;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .right-side {
            flex: 1;
            background-color: #ffe6ec; /* Soft pink */
        }

        .login-box {
            width: 300px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            animation: slideIn 1s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .login-box h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            background-color: #4e944f;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-box button:hover {
            background-color: #3d7d3e;
        }

        .error {
            background-color: #ffe0e0;
            color: red;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            border-radius: 4px;
        }

        @media screen and (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .right-side {
                height: 30vh;
            }
            .left-side {
                height: 70vh;
            }
        }
    </style>
</head>
<body>

<div class="left-side">
    <div class="login-box">
        <h2>Sign In</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form action="auth.php" method="POST">
            <input type="text" name="username" placeholder="Email or Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
        <p style="text-align:center;"><a href="#">Forgot your password?</a></p>
    </div>
</div>

<div class="right-side"></div>

</body>
</html>
