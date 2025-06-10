<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
        }

        .register-scroll-container {
            width: 100%;
            height: 100vh;
            overflow-y: auto;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background-image: url('{{ asset('images/background/flower.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .register-modal {
            background-color: rgba(255, 255, 255, 0.9);
            width: 600px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #e965a7;
            margin-bottom: 20px;
        }

        .logo span {
            color: #000;
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

        .register-modal label {
            text-align: left;
            display: block;
            margin-top: 6px;
            margin-bottom: 4px;
            font-weight: 500;
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

        .register-modal input:focus {
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

        .bottom-link {
            font-size: 14px;
            margin-top: 20px;
        }

        .register-modal .gray-text {
            color: gray;
        }

        .name-phone-container,
        .password-container {
            display: flex;
            gap: 10px;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .name-field,
        .phone-field,
        .password-field,
        .confirm-password-field {
            width: 48%;
        }

        .postal-city-country-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: nowrap;
        }

        .postal-code-container,
        .city-container,
        .country-container {
            flex: 1;
        }

        .address-container {
            margin-bottom: 0;
        }

        @media (max-width: 767px) {
            .register-modal {
                width: 90%;
                padding: 28px 20px;
            }

            .logo {
                font-size: 28px;
            }

            .register-modal h2 {
                font-size: 20px;
            }

            .register-modal p {
                font-size: 13px;
            }

            .register-modal input {
                font-size: 14px;
                padding: 10px;
            }

            .register-modal button {
                font-size: 14px;
                padding: 10px;
            }

            .name-phone-container,
            .password-container,
            .postal-city-country-container {
                flex-direction: column;
            }

            .name-field,
            .phone-field,
            .password-field,
            .confirm-password-field,
            .postal-code-container,
            .city-container,
            .country-container {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .register-modal {
                max-width: 360px;
                padding: 20px 16px;
            }

            .logo {
                font-size: 24px;
            }

            .register-modal h2 {
                font-size: 18px;
            }

            .register-modal p {
                font-size: 12px;
            }

            .register-modal input {
                font-size: 13px;
                padding: 9px;
            }

            .register-modal button {
                font-size: 13px;
                padding: 9px;
            }
        }
    </style>
</head>

<body>
    <div class="register-scroll-container">
        <div class="register-modal">
            <div class="logo">Skintifix <span>Beauty Store</span></div>
            <h2>Account Register</h2>
            <p class="gray-text">Enter your information to create an account</p>

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <div class="name-phone-container">
                    <div class="name-field">
                        <label for="name">Name</label>
                        <input type="text" name="name" required />
                    </div>
                    <div class="phone-field">
                        <label for="phone">Phone Number</label>
                        <input type="tel" name="phone" required pattern="[0-9]{10,15}" />
                    </div>
                </div>

                <label for="email">Email</label>
                <input type="email" name="email" placeholder="name@example.com" required />

                <div class="address-container">
                    <label for="address">Address</label>
                    <input type="text" name="address" required />
                </div>

                <div class="postal-city-country-container">
                    <div class="postal-code-container">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" name="postal_code" placeholder="e.g. 12345" required />
                    </div>
                    <div class="city-container">
                        <label for="city">City</label>
                        <input type="text" name="city" required />
                    </div>
                    <div class="country-container">
                        <label for="country">Country</label>
                        <input type="text" name="country" required />
                    </div>
                </div>

                <div class="password-container">
                    <div class="password-field">
                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="Password (min 8 characters)" required />
                    </div>
                    <div class="confirm-password-field">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Confirm your password"
                            required />
                    </div>
                </div>

                <button type="submit">Register</button>
            </form>

            <p class="bottom-link gray-text">
                Already have an account? <a href="{{ route('login') }}"><b>Login here</b></a>
            </p>
        </div>
    </div>
</body>

</html>
