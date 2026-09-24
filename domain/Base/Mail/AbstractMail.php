<?php

namespace Base\Base\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

abstract class AbstractMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    abstract protected function subject(): string;

    abstract protected function view(): string;

    abstract protected function data(): array;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->view(),
            with: $this->data(),
        );
    }
}
