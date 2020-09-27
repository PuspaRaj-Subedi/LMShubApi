<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusUpdate extends Notification
{
    use Queueable;
    protected $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
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
        if($this->status == 3)
        {
            $url = url('/api/student/borrow');
            return (new MailMessage)
                ->line('You are receiving this email because we accepted a Book Borrow request form your account due to some voilance of our site.')
                ->action('Accepted Request Borrow', url($url))
                ->line('Enjoy Reading your requested Book');
        }
        elseif($this->status ==2)
        {
            $url = url('/api/student/borrow');
            return (new MailMessage)
                ->line('You are receiving this email because we rejected a Book Borrow request form your account due to some voilance of our site.')
                ->action('Rejected Request Borrow', url($url))
                ->line('Please try after returning the previous book.');
        }
        else
        {
            $url = url('/api/student/borrow/');
            return (new MailMessage)
                ->line('You are receiving this email because we received a Book Borrow request form your account.')
                ->action('Request Borrow', url($url))
                ->line('Check your Request is accepted or Rejected');
        }
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
