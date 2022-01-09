<?php

namespace Maduser\Laravel\Support\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Gate;

class GateList extends Command
{

    /**
     * @var string
     */
    protected $signature = 'gate:list';

    /**
     * @var string
     */
    protected $description = 'List a the available Gates';

    /**
     *
     */
    public function handle()
    {
        dump(collect(Gate::abilities())->keys());
    }
}
