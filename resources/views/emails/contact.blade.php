<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
    <h2 style="color: #004080;">New Contact Form Submission</h2>
    <p><strong>Name:</strong> {{ $data['m_firstname'] }} {{ $data['m_lastname'] }}</p>
    <p><strong>Email:</strong> {{ $data['m_email'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $data['m_description'] }}</p>
</body>

</html>