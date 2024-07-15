<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->line('Your OTP is: ' . $this->otp)
                    ->line('This OTP will expire shortly.')
                    ->line('If you did not request a password reset, no further action is required.');
    }
}
