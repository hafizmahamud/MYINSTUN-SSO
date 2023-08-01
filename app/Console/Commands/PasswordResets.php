<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Http\Request;
use DB;
use Auth;
use Artisan;

class PasswordResets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:passwordresets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command run every day to delete data inside table password_resets';

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
     * @return mixed
     */
    public function handle()
    {
        DB::table('password_resets')->delete();
    }
}
