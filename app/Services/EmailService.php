// app/Services/EmailService.php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailBlast;

class EmailService
{
    public function sendEmailBlast($umkms, $subject, $message)
    {
        foreach ($umkms as $umkm) {
            Mail::to($umkm->email)->send(new EmailBlast($subject, $message));
        }
    }
}
