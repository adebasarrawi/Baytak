<?php

namespace App\Mail;

use App\Models\PropertyAppraisal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The property appraisal instance.
     *
     * @var \App\Models\PropertyAppraisal
     */
    public $appraisal;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\PropertyAppraisal  $appraisal
     * @return void
     */
    public function __construct(PropertyAppraisal $appraisal)
    {
        $this->appraisal = $appraisal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Your Property Appraisal Appointment - Status Update';
        
        // Customize subject based on status
        switch ($this->appraisal->status) {
            case 'confirmed':
                $subject = 'Your Property Appraisal Appointment has been Confirmed';
                break;
            case 'cancelled':
                $subject = 'Your Property Appraisal Appointment has been Cancelled';
                break;
            case 'completed':
                $subject = 'Your Property Appraisal Appointment has been Completed';
                break;
        }
        
        return $this->subject($subject)
                    ->markdown('emails.appraisals.status-updated');
    }
}