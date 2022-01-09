<?php namespace Maduser\Laravel\Support\Providers;

use Maduser\Laravel\Support\Console\Commands\AuthPassword;
use Maduser\Laravel\Support\Console\Commands\ClearAllCaches;
use Maduser\Laravel\Support\Console\Commands\DropTables;
use Maduser\Laravel\Support\Console\Commands\DumpDatabase;
use Maduser\Laravel\Support\Console\Commands\ExecuteSql;
use Maduser\Laravel\Support\Console\Commands\GateList;
use Maduser\Laravel\Support\Console\Commands\InspireSlack;
use Maduser\Laravel\Support\Console\Commands\SlackMessage;

/**
 * Class MaduserServiceProvider
 *
 * @package Maduser\Laravel\Support
 */
class MaduserServiceProvider extends AbstractServiceProvider
{
    /**
     * Declares the available artisan commands classes
     *
     * @return array
     */
    public function artisan(): array
    {
        return [
            AuthPassword::class,
            ClearAllCaches::class,
            DropTables::class,
            DumpDatabase::class,
            ExecuteSql::class,
            GateList::class,
            InspireSlack::class,
            SlackMessage::class
        ];
    }
}
