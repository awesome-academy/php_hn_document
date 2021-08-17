<?php

namespace App\Jobs;

use App\Mail\Receipt;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $receipt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $receipt)
    {
        $this->user = $user;
        $this->receipt = $receipt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new Receipt($this->receipt, $this->user));
    }
}
