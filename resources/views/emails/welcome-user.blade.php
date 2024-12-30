<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>

    <h3>Your Account Credentials:</h3>
    <p><strong>Email:</strong> {{ $details['email'] }}</p>
    <p><strong>Password:</strong> {{ $details['password'] }}</p>

    <p>Thank you for joining us. Please keep your credentials secure.</p>
</body>
</html>
