<?php

namespace Maduser\Laravel\Support\Traits;

/**
 * Trait ArrayableTrait
 *
 * @package maduser/laravel-support
 */
trait ArrayableTrait {

  use CollectableTrait;

  /**
   * @return array
   */
  public function toArray(): array {
    return $this->collect()->toArray();
  }
}
