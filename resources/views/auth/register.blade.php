<?php
// register.php

// Proses registrasi akan ditangani di sini (validasi dan simpan data pengguna)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Validasi dan simpan data pengguna (gantilah dengan kode untuk menyimpan ke database)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Hash password sebelum disimpan
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Simulasi menyimpan data ke database (Ganti dengan query database nyata)
        // INSERT INTO users (name, phone, email, address, password) VALUES ('$name', '$phone', '$email', '$address', '$hashedPassword');

        echo "Account created successfully! <a href='login.php'>Login here</a>";
    } else {
        echo "Invalid email format.";
    }
}
?>

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
            background-color: #ffe2ee; /* Soft pink background */
        }

        .register-modal {
            background-color: #fff;
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
            padding: 15px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
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
    </style>
</head>
<body>

    <div class="register-modal">
        <!-- Logo -->
        <div class="logo">Skintifix <span style="color: #000000;">Beauty Store</span></div>
        
        <h2>Register</h2>
        
        <p>Sign up your account</p>

        <!-- Form untuk registrasi -->
       <form action="{{ route('login') }}" method="GET">
            <input type="text" name="name" placeholder="Name" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>

        <!-- Link untuk kembali ke halaman login jika sudah punya akun -->
        <p class="bottom-link">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>

</body>
</html>
