<?php

namespace Maduser\Laravel\Support\Traits;

use Illuminate\Support\Str;

/**
 * Trait SettableTrait
 *
 * @package maduser/laravel-support
 */
trait CallSettersTrait {

    /**
     * @param array $items
     *
     * @return $this
     */
  public function callSetters(array $items) {
    foreach ($items as $key => $value) {
      $method = 'set' . Str::studly($key);
      if (method_exists($this, $method)) {
        $this->{$method}($value);
      }
    }

    return $this;
  }

}
