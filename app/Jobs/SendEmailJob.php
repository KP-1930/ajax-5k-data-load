<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $mail_to, $template;
    public $tries = 3;
    public $timeout = 120;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail_to, $template)
    {
        $this->mail_to = $mail_to;
        $this->template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->mail_to)->send($this->template);
        } catch (\Exception $e) {
            Log::error('Mail sending failed for recipient ' . $this->mail_to . ' | Error: ' . $e->getMessage());
            // Optional: rethrow exception if you want it to be retried
            throw $e;
        }
    }

    public function failed(\Exception $exception)
    {
        Log::error('Job failed for recipient ' . $this->mail_to . ' | Error: ' . $exception->getMessage());
        // Additional failure handling logic can be placed here
    }
}
