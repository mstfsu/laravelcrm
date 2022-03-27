<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ImportNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
class NotifyUserImportComplete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    private $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $type)
    {
        $this->type=$type;
        $this->user = $user;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->user->notify(new  ImportNotification($this->type));
    }

}
