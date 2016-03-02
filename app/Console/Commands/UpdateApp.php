<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Collective\Remote\RemoteFacade as SSH;

class UpdateApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs an update in admin micro service';

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

        $this->runShellCommand('git pull origin master');
        $this->runShellCommand('git checkout master');
        $this->runShellCommand('composer install');
        $this->runShellCommand('php artisan doctrine:migrations:migrate');
    }

    public function runShellCommand($command){
        $output = array();

        echo PHP_EOL.PHP_EOL.'Run: "'.$command.'"'.PHP_EOL;
        exec($command, $output);

        foreach($output as $line){
            echo '- '.$line.PHP_EOL;
        }
    }
}
