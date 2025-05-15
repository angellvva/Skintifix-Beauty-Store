<!-- views/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skintifix Beauty Store - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8E1F4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        /* Header Text */
        h1 {
            font-size: 2.5rem;
            color: #D9576A; /* Soft Pink */
            margin-bottom: 20px;
        }

        .login-container p {
            font-size: 1rem;
            color: #777;
            margin-bottom: 30px;
        }

        /* Input Fields */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #D9576A; /* Soft Pink */
        }

        /* Submit Button */
        button {
            width: 100%;
            padding: 15px;
            background-color: #D9576A; /* Soft Pink */
            color: white;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #C14D5C;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer Text */
        .footer-text {
            margin-top: 20px;
            font-size: 1rem;
            color: #D9576A;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Log In</h1>
        <p>Welcome back! Please log in to your account</p>
        
        <form action="your-login-script.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log In</button>
        </form>

        <p class="footer-text">Skintifix Beauty Store</p>
    </div>
</body>
</html>
