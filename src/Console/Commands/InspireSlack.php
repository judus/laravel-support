<?php

namespace Maduser\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Log;

/**
 * Class ClearAllCaches
 *
 * @package Maduser\Laravel\Support\Console\Commands
 */
class InspireSlack extends Command
{

    /**
     * @var string
     */
    protected $signature = 'slack:inspire';

    /**
     * @var string
     */
    protected $description = 'Sends an inspiring quote to slack';

    /**
     *
     */
    public function handle()
    {
        Log::channel('slackInfo')->error(Inspiring::quote());
    }
}
