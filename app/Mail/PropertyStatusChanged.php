<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Property;

class PropertyStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    public function build()
    {
        return $this->subject('Your Property Status Has Been Updated')
                    ->markdown('emails.property_status_changed');
    }
}