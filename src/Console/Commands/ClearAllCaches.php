<?php

namespace Maduser\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class ClearAllCaches
 *
 * @package Maduser\Laravel\Support\Console\Commands
 */
class ClearAllCaches extends Command
{

    /**
     * @var string
     */
    protected $signature = 'clear:all';

    /**
     * @var string
     */
    protected $description = 'Clears all caches';

    /**
     *
     */
    public function handle()
    {
        $this->call('optimize:clear');
        $this->call('event:clear');
        $this->call('debugbar:clear');
    }
}
