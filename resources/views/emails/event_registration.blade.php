<!DOCTYPE html>
<html>

<head>
    <title>Event Registration Confirmation</title>
</head>

<body>
    <h1>Event Registration Confirmation</h1>
    <p>Dear, {{ $registration->umkm->nama_pemilik }}</p>
    <p>You have successfully registered for the event:</p>
    <ul>
        <li>Event: {{ $registration->event->nama_event }}</li>
        <li>Date: {{ $registration->date }}</li>
        <li>Status: {{ $registration->status ? 'Confirmed' : 'Pending' }}</li>
    </ul>
    <p>Thank you for registering!</p>
</body>

</html>