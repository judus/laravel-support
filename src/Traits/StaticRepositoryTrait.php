<?php

namespace Maduser\Laravel\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * Trait RepositoryTrait
 *
 * @package Drupal\sva_form\Traits
 */
trait StaticRepositoryTrait
{
  /**
   * @var Collection
   */
  protected static $repository;

  /**
   * @return \Illuminate\Support\Collection
   */
  public static function repository(): Collection
  {
      !is_null(static::$repository) || static::$repository = collect();

      return static::$repository;
  }

  public static function __callStatic($name, $arguments)
  {
      return static::repository()->{$name}(...$arguments);
  }
}
