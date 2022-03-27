<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Library\BackupMysql;
use DB;
use App\Jobs\BackupJob;

class RestoreBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected  $path;
    protected  $file_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path,$file_name)
    {$this->path=$path;
        $this->file_name=$file_name;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $host = DB::connection()->getConfig('host');
        $user = DB::connection()->getConfig('username');
        $password = DB::connection()->getConfig('password');
        $database = DB::connection()->getConfig('database');
        dispatch(new BackupJob());
        $bk = new BackupMysql( $this->path);
        $bk->setMysql(['host' => $host, 'user' => $user, 'pass' => $password, 'dbname' => $database]);
        $bk->restore($this->file_name); //restore an dump database



    }
}
