<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Inquiry extends Mailable
{
    use Queueable, SerializesModels;

    protected $inquiry;

    /**
     * Create a new message instance.
     *
     * @param $inquiry
     */
    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->inquiry->email)
            ->markdown('emails.inquiry.send')
            ->with([
                'from' => $this->inquiry->first_name .' '. $this->inquiry->last_name,
                'email' => $this->inquiry->email,
                'iam' => $this->inquiry->select,
                'message' => $this->inquiry->message
            ]);
    }
}
