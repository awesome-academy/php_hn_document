<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update upload and download times to members monthly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('users')->update([
            'download_free' => config('command.user_download'),
            'upload' => config('command.user_upload'),
        ]);
    }
}
