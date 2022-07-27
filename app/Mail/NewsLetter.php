<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsLetter extends Mailable
{
    use Queueable, SerializesModels;

    public $image;
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $image = null)
    {
        $this->content = $content;
        $this->image = $image;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newsletter', ['content' => $this->content, 'image' => $this->image]);
    }
}
