<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    /**
     * Create a new message instance.
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('noreply@tagsole.com', 'TAG & SOLE')
                    ->subject('Nuevo mensaje de contacto: ' . $this->contactData['subject'])
                    ->view('emails.contact-form')
                    ->with([
                        'contactData' => $this->contactData,
                        'fecha' => now()->format('d/m/Y H:i:s')
                    ]);
    }
}
