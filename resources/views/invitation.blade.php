<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $title }}</h1>
<p>Hello {{ $name }},</p>
<p>You are invited to join our website!</p>
<p>Please click the following link to create your account:</p>
<a href="{{ $invitationLink }}">{{ $invitationLink }}</a>
</body>
</html>