<?php

namespace App\Console\Commands;

use Collective\Remote\RemoteFacade as SSH;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class UpdateApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:app {git_branch?}';

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
        $branch = $this->argument('git_branch') ?: 'master';

        $isCheckout = $this->runShellCommand("git checkout {$branch}");
        if ($isCheckout) {
            $this->runShellCommand("git pull origin {$branch}");
        }

        if (!$isCheckout && !$this->confirm("GIT branch switching failed.\nDo you wish to continue? [y|N]", true)) {
            return;
        }

        $this->runShellCommand('composer install');
        $this->runShellCommand('php artisan doctrine:migrations:migrate');
        $this->runShellCommand('npm install && gulp');
    }

    /**
     * @param $command
     * @return bool
     */
    public function runShellCommand($command) {
        echo "\n\n======== Run: ========\n{$command}\n======================\n";

        $process = new Process($command);
        $result  = $process->run(array($this, 'processOutput'));
        return (0 == $result);
    }

    /**
     * @param string $type
     * @param string $buffer
     */
    public function processOutput($type, $buffer) {
        if (Process::ERR === $type) {
            echo 'ERR > ' . $buffer;
        } else {
            echo $buffer;
        }
    }
}
