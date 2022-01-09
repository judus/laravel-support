<?php

namespace Maduser\Laravel\Support\Eloquent;

/**
 * Class Log
 *
 * @package Maduser\Laravel\Resource\Eloquent
 */
class Log extends AbstractModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'instance',
        'message',
        'channel',
        'level',
        'level_name',
        'context',
        'remote_addr',
        'user_agent',
        'created_by',
        'created_at'
    ];
}
