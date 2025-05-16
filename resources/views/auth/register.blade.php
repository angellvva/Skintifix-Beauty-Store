<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            background-attachment: fixed;
        }

        .register-modal {
            background-color: rgba(255, 255, 255, 0.9); 
            width: 380px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .register-modal h2 {
            font-size: 24px;
            color: #080808;
            margin-bottom: 10px;
        }

        .register-modal p {
            font-size: 14px;
            color: #090909;
            margin-bottom: 20px;
        }

        .register-modal input[type="text"],
        .register-modal input[type="email"],
        .register-modal input[type="password"],
        .register-modal input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin: 6px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .register-modal input[type="text"]:focus,
        .register-modal input[type="email"]:focus,
        .register-modal input[type="password"]:focus,
        .register-modal input[type="tel"]:focus {
            border-color: #e965a7;
            outline: none;
        }

        .register-modal button {
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

        .register-modal button:hover {
            background-color: #c84d85;
        }

        .register-modal p a {
            color: #e965a7;
            text-decoration: none;
        }

        .register-modal p a:hover {
            text-decoration: underline;
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #e965a7;
            margin-bottom: 20px;
        }

        .bottom-link {
            font-size: 14px;
            margin-top: 20px;
        }

        .register-modal label {
            text-align: left;
            display: block;
            margin-top: 6px;
        }

        .register-modal .gray-text {
            color: gray;
        }
    </style>
</head>
<body>

    <div class="register-modal">
        <!-- Logo -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>
        
        <h2>Account Register</h2>
        
        <p class="gray-text">Enter your information to create an account</p>

        <!-- Form untuk registrasi -->
       <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="" required>

            <label for="phone">Phone Number</label>
            <input type="tel" name="phone" placeholder="" required>

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="name@example.com" required>

            <label for="address">Address</label>
            <input type="text" name="address" placeholder="" required>

            <label for="password">Password</label>
            <input type="password" name="password" required minlength="8" placeholder="Password (min 8 characters)">

            <label for="confirm-password">Confirm Password</label>
            <input type="password" name="password_confirmation" placeholder="" required>

            <button type="submit">Register</button> 
        </form>

        <!-- Link untuk kembali ke halaman login jika sudah punya akun -->
        <p class="bottom-link gray-text" style="margin-top: 20px; margin-bottom: 14px;">Already have an account? <a href="{{ route('login') }}"><b>Login here</b></a></p>
    </div>

</body>
</html>
