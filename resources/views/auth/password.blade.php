<?php
// forget-password.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil email yang dimasukkan oleh pengguna
    $email = $_POST['email'];

    // Validasi email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Simulasi pengecekan apakah email terdaftar di database
        // Gantilah kode ini untuk memeriksa email di database Anda
        $userExists = true; // Misalnya email ditemukan di database

        if ($userExists) {
            // Generate token untuk reset password
            $token = bin2hex(random_bytes(50)); // Token acak

            // Simpan token ke dalam database (buat tabel password_resets jika belum ada)
            // Contoh query: INSERT INTO password_resets (email, token) VALUES ('$email', '$token');

            // Link reset password
            $resetLink = "http://yourdomain.com/reset-password.php?token=unique_token_value";

            // Kirim email dengan link reset
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password:\n$resetLink";
            $headers = "From: no-reply@yourdomain.com";

            if (mail($email, $subject, $message, $headers)) {
                echo "Password reset link has been sent to your email address.";
            } else {
                echo "Failed to send email. Please try again.";
            }
        } else {
            echo "Email not found.";
        }
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

        .forgot-password-modal input[type="email"] {
            width: 100%;
            padding: 15px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .forgot-password-modal input[type="email"]:focus {
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
        <form action="{{ route('password.reset') }}" method="GET">
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Send Password Reset Link</button>
        </form>

        <p><a href="{{ route('login') }}">Back to Login</a></p>
    </div>

</body>
</html>
