<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public $user;
    public function __construct($data,$user)
    {
        //
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Mail',
            // from:new Address(),
            replyTo: [
                new Address("bmv.buiminhvu@gmail.com","mvu"),
            ],
            
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail',
            with: [
                'username' => $this->user->username
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
        // $filePath = 'c:/Users/84981/Pictures/Screenshots/Screenshot 2024-06-19 133040.png';
        // $fileName = basename($filePath); 
    
        return [
            // Attachment::fromPath($filePath)
            //     ->as($fileName) 
            //     ->withMime('image/png') 
        ];
    }
}
