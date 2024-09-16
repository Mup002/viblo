<?php

namespace App\Jobs;

use App\Mail\TestMail;
use App\Mail\UserVerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    
    protected $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        logger()->info('Sending email to: ' . $this->data->email);
        try {
            Mail::to($this->data->email)->send(new UserVerifyEmail($this->data));
            logger()->info('Email sent successfully.');
        } catch (\Exception $e) {
            logger()->error('Failed to send email: ' . $e->getMessage());
        }
    }
}
