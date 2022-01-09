<?php

namespace Maduser\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class DropTables extends Command
{
    protected $signature = 'db:drop';

    protected $description = 'Drop all tables in database';

    public function handle()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        if ($this->confirm(
            'Are you sure you want to delete all the data ' .
            'in the database ' . $database . '?'
        )) {
            $this->dropAllTables($database, $username, $password);
        }
    }

    protected function dropAllTables()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $port = config('database.connections.mysql.port');
        $host = config('database.connections.mysql.host');

        $dsn = sprintf(
            'mysql:dbname=%S;host=%s;port=%s;charset=utf8',
            $database, $host, $port
        );

        $pdo = new PDO($dsn, $username, $password);

        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

        $query =
            "SELECT concat('DROP TABLE IF EXISTS `', TABLE_SCHEMA, '`.`', TABLE_NAME, '`;') " .
            "FROM information_schema.tables " .
            "WHERE table_schema = '" . $database . "'";

        foreach ($pdo->query($query) as $row) {
            $this->line($row[0]);
            $pdo->exec($row[0]);
        }

        $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    }
}
