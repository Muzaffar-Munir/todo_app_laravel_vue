<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class matchedProfessonals extends Mailable
{
    use Queueable, SerializesModels;
    public $objProfessionals;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($objects)
    {
        //
        $this->objProfessionals = $objects;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@upsellupscale.com')
                    ->view('mails.matchedProfessonals');
    }
}
