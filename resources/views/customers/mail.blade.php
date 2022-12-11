<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
</head>
<body>
    <p>Dear Market Operations,</p>
    <p>Readings from {{ $data['virtualMeter']->name }} have been rejected by {{ auth()->user()->name }}.</p>
    <p>Kindly click on the link below to view the meters.</p>
    <p><a href="{{ route('customers.show', $data['customer']) }}">Customer Meters</a></p>
    <p>Best regards,<br>Telemetry Team</p>
</body>
</html>