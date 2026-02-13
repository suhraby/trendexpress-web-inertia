<?php

namespace App\Notifications;

use App\Models\ContactInfo;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $contacts = ContactInfo::select('id', 'type', 'value')
            ->orderByRaw("CASE type
                    WHEN 'whatsapp' THEN 1
                    WHEN 'instagram' THEN 2
                    WHEN 'phone' THEN 3
                    WHEN 'email' THEN 4
                    ELSE 5
                END")
            ->get();

        return (new MailMessage)
            ->subject('Verify Email Address')
            ->view('emails.verify-email', [
                'url' => $verificationUrl,
                'user' => $notifiable,
                'contacts' => $contacts,
            ]);
    }
}
