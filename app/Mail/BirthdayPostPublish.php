<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BirthdayPostPublish extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
        ->view('email-template.template')->with('data', $this->data);
    }
}
