<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Invite extends Notification
{
    use Queueable;
    protected $notificationUrl;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notificationUrl)
    {
        $this->notificationUrl = $notificationUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable) : array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(mixed $notifiable) : MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action',$this->notificationUrl)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable) : array
    {
        return [
            //
        ];
    }
}
