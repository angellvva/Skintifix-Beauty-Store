<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <form action="{{ route('forgot.password.send') }}" method="POST">
        @csrf
        <h2>Forgot your password?</h2>
        <p>Enter your email address to receive a password reset link.</p>

        @if(session('status'))
            <p style="color: green;">{{ session('status') }}</p>
        @endif

        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
