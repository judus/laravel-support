<?php

namespace Maduser\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ExecuteSql extends Command
{
    protected $signature = 'db:exec {file}';

    protected $description = 'Execute a sql file from the project directory';

    public function handle()
    {
        if ($this->confirm('Are you sure you want to execute the instruction ' .
            'in the file "' . $this->argument('file') . '?"'
        )) {
            $this->executeSqlFile();
        }
    }

    protected function executeSqlFile()
    {
        $process = new Process(sprintf(
            'mysql -P %s -h %s -u%s -p%s %s < %s',
            config('database.connections.mysql.port'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            $this->argument('file')
        ));

        try {
            $process->mustRun();
            $this->info('SQL executed');
        } catch (ProcessFailedException $exception) {
            $this->error('The SQL execution has failed');
        }
    }

}
