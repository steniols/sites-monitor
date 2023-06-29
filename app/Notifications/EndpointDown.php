<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EndpointDown extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Check $check
    )
    {
        //
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
    public function toMail(object $user): MailMessage
    {
        $endpoint = $this->check->endpoint;
        $error = $endpoint->status_code;
        $site = $endpoint->site;
        return (new MailMessage)
                    ->error()
                    ->subject("Site com erro({$site->url})")
                    ->line("O endpoint {$endpoint->endpoint} está com erro: ({$error})")
                    ->action('Verificar', route('endpoints.index', $site->id))
                    ->line('Obrigado!');
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
