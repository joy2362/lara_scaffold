<?php

namespace Modules\Auth\Emails\Api\V1;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetPasswordEmail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public string $email_subject;

    public string $lang;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public string $token)
    {
        $this->email_subject = 'Reset your password';
        $this->lang = 'en';
        // $this->lang = $user->language;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __($this->email_subject, [], strtolower($this->lang)),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'auth::mail.reset-password',
            with: [
                'user' => $this->user,
                'code' => $this->token,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
