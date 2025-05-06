<?php

namespace App\Notifications;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyApproved extends Notification
{
    use Queueable;

    protected $property;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Property $property
     * @return void
     */
    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Property Listing Approved')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Congratulations! Your property listing has been approved and is now publicly visible.')
            ->line('Property: ' . $this->property->title)
            ->action('View Property', url('/properties/' . $this->property->id))
            ->line('Thank you for using our platform!');
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
            'property_id' => $this->property->id,
            'title' => $this->property->title,
            'message' => 'Your property listing "' . $this->property->title . '" has been approved.',
            'type' => 'property_approved'
        ];
    }
}