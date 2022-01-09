<?php namespace Maduser\Laravel\Support\Traits;

/**
 * Trait Blamable
 *
 * @package Maduser\Laravel\Support\Traits
 */
trait Blamable
{
    /**
     * @return mixed
     */
    public function updatedBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'updated_by');
    }

    /**
     * @return mixed
     */
    public function createdBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'created_by');
    }

    /**
     * @return mixed
     */
    public function deletedBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'deleted_by');
    }
}
