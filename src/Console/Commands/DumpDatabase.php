<?php

namespace Maduser\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DumpDatabase extends Command
{
    protected $signature = 'db:dump';

    protected $description = 'Dump the database to storage/dumps';

    protected $process;

    protected $targetDir;

    public function __construct()
    {
        parent::__construct();

        $this->targetDir = storage_path('app/dumps/' . date('Y-m-d--H-i-s') . '.sql');

        $this->process = new Process([sprintf(
            'mysqldump -P %s -h %s -u%s -p%s %s > %s',
            config('database.connections.mysql.port'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            $this->targetDir
        )]);
    }

    public function handle()
    {
        try {
            $this->process->mustRun();
            $this->info('Database dumped to ' . $this->targetDir);
        } catch (ProcessFailedException $exception) {
            $this->error('The database dump has failed');
        }
    }
}
