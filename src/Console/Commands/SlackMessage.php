<?php

namespace Maduser\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Class ClearAllCaches
 *
 * @package Maduser\Laravel\Support\Console\Commands
 */
class SlackMessage extends Command
{

    /**
     * @var string
     */
    protected $signature = 'slack:message {message}';

    /**
     * @var string
     */
    protected $description = 'Sends an inspiring quote to slack';

    /**
     *
     */
    public function handle()
    {
        Log::channel('slackInfo')->info($this->argument('message'));
    }
}
