<?php

namespace App\Notifications;

use App\Models\Testimonial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTestimonialSubmitted extends Notification
{
    use Queueable;

    protected $testimonial;
    protected $email;

    /**
     * Create a new notification instance.
     */
    public function __construct(Testimonial $testimonial, $email)
    {
        $this->testimonial = $testimonial;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Testimonial Submission')
            ->greeting('Hello!')
            ->line('A new testimonial has been submitted by ' . $this->testimonial->name . '.')
            ->line('Email: ' . $this->email)
            ->when($this->testimonial->area, function ($message) {
                return $message->line('Area: ' . $this->testimonial->area->name);
            })
            ->line('Rating: ' . $this->testimonial->rating . ' stars')
            ->line('Message: "' . \Illuminate\Support\Str::limit($this->testimonial->content, 100) . '"')
            ->action('Review Testimonial', url(route('admin.testimonials.edit', $this->testimonial)))
            ->line('Please review and approve this testimonial if appropriate.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'testimonial_id' => $this->testimonial->id,
            'name' => $this->testimonial->name,
            'rating' => $this->testimonial->rating,
            'area' => $this->testimonial->area ? $this->testimonial->area->name : null,
            'email' => $this->email,
        ];
    }
}