<?php

namespace Maduser\Laravel\Support\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Maduser\Laravel\Support\Traits\Blamable;
use Maduser\Laravel\Resource\Traits\Resourceable;
use Maduser\Generic\Traits\Paginatable;

/**
 * Class AbstractModel
 *
 * @package Maduser\Laravel\Support\Eloquent\Abstracts
 */
abstract class AbstractModel extends Model
{
    use Blamable;
    use Paginatable;
    use Resourceable;

    /**
     * The default number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 1000;

    /**
     * The default resource class associated with this model
     *
     * @var string
     */
    protected $resourceClass = '';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
