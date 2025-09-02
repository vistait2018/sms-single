<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTPNotification extends Notification
{
    use Queueable;

     protected $user;
     protected $otp;
     protected $validity;

    /**
     * Create a new notification instance.
     */
     public function __construct($user ,$otp, $validity)
    {
        $this->user = $user;
        $this->otp = $otp;
        $this->validity = $validity;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $ip = request()->ip();

    // Call ipinfo.io (free tier) for geo data


        $response = Http::withOptions([
            'verify' => false,
        ])->get("https://ipinfo.io/json?token=" . env('IPINFO_TOKEN'));


    $city    = data_get($response->json(), 'city', 'Unknown City');
    $region  = data_get($response->json(), 'region', 'Unknown Region');
    $country = data_get($response->json(), 'country', 'Unknown Country');
    $coordinates = data_get($response->json(),'Coordinates','Unknown coordinates');
    $loginLocation = "{$city}, {$region}, {$country}, {$coordinates}";
        $logoUrl       = config('app.url') . '/logo/logo.png';
        return (new MailMessage)
        ->subject('User OTP  Notification')
        ->markdown('notifications.emails.welcome_user', [
            'user'           => $this->user,
            'logoUrl'        => $logoUrl? $logoUrl :'#',
            'loginLocation'  => $loginLocation,
            'otp'            =>$this->otp,
            'validity'       =>$this->validity,
            'loginUrl'       => env('APP_LOGIN_URL'),
            'passwordResetUrl' => env('APP_PASSWORD_RESET_URL'),

        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
