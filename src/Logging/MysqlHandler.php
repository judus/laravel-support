<?php

namespace Maduser\Laravel\Support\Logging;

use Exception;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Maduser\Laravel\Support\Eloquent\Log;

/**
 * Class MysqlHandler
 *
 * @package Maduser\Laravel\Support\Logging
 */
class MysqlHandler extends AbstractProcessingHandler
{
    /**
     * @var
     */
    protected $table;

    /**
     * @var
     */
    protected $connection;

    /**
     * MysqlHandler constructor.
     *
     * @param array $config
     * @param int   $level
     * @param bool  $bubble
     */
    public function __construct(
        array $config,
        int $level = Logger::DEBUG,
        bool $bubble = true
    ) {
        parent::__construct($level, $bubble);
    }

    /**
     * @param array $record
     */
    protected function write(array $record): void
    {
        try {
            Log::create([
                'instance' => gethostname(),
                'message' => $record['message'],
                'channel' => $record['channel'],
                'level' => $record['level'],
                'level_name' => $record['level_name'],
                'context' => json_encode($record['context']),
                //'remote_addr' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
                'remote_addr' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_by' => Auth::id() > 0 ? Auth::id() : null,
                'created_at' => $record['datetime']->format('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {

        }
    }
}
