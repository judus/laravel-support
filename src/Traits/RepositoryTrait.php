<?php

namespace Maduser\Laravel\Support;

use Illuminate\Support\Collection;

/**
 * Trait RepositoryTrait
 *
 * @package Drupal\sva_form\Traits
 */
trait RepositoryTrait {

  /**
   * @var Collection
   */
  protected $repository;

  /**
   * @return \Illuminate\Support\Collection
   */
  public function repository(): Collection {
    !is_null($this->repository) || $this->repository = collect();
    return $this->repository;
  }

  /**
   * @param $key
   * @param $value
   *
   * @return \Illuminate\Support\Collection
   */
  public function set($key, $value): Collection {
    $this->repository()->put($key, $value);
    return $this->repository();
  }

  /**
   * @param $key
   *
   * @return mixed
   */
  public function get($key) {
    return $this->repository()->get($key);
  }

}
