<?php

namespace App\Notifications;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyRejected extends Notification
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
            ->subject('Property Listing Rejected')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your property listing has been rejected.')
            ->line('Property: ' . $this->property->title)
            ->line('Reason for rejection: ' . $this->property->rejection_reason)
            ->line('You can update your property listing and submit it again for approval.')
            ->action('View Property', url('/properties/my-properties'))
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
            'message' => 'Your property listing "' . $this->property->title . '" has been rejected.',
            'reason' => $this->property->rejection_reason,
            'type' => 'property_rejected'
        ];
    }
}