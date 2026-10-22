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

    abstract protected function getSubject(): string;
    abstract protected function getView(): string;

    abstract protected function getdata(): array;

    public function build(): static
    {
        return $this->subject($this->getSubject());
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->getSubject(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->getView(),
            with: $this->getData(),
        );
    }
}
