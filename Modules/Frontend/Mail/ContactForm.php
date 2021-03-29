<?php

namespace Modules\Frontend\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'New message from Contact Form';

    private MailMessage $message;

    public function __construct($data)
    {
        $this->message = (new MailMessage)
            ->greeting('Hello, you have new message from contact form.')
            ->salutation(null);
        foreach ($data as $field => $text) {
            $field = ucfirst($field);
            if ($text) {
                $this->message->line("$field : $text");
            }
        }
    }

    public function build(): self
    {
        return $this->markdown('vendor.notifications.email', $this->message->data());
    }
}
