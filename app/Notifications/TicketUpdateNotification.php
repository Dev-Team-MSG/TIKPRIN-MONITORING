<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketUpdateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, $isClose=false)
    {
        //
        $this->ticket = $ticket;
        $this->isClose = $isClose;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->isClose) {
            return (new MailMessage)
                    ->line("tiket dengan no : ". $this->ticket->no_ticket." Telah selesai dan berhasil di close")
                    ->action('Lihat Tiket', url('/tiket/detail/'.$this->ticket->no_ticket))
                    ->line('Thank you for using our application!');
        }
        return (new MailMessage)
                    ->line('Ada update nih dari tiket dengan nomor : '. $this->ticket->no_ticket)
                    ->action('Lihat Tiket', url('/tiket/detail/'.$this->ticket->no_ticket))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
