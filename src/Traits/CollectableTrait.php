<?php

namespace Maduser\Laravel\Support\Traits;

use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Trait CollectableTrait
 *
 * @package maduser/laravel-support
 */
trait CollectableTrait
{

    /**
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    protected function shouldIgnore(ReflectionProperty $property): bool
    {
        if (isset($this->ignore)) {
            if ($property->isPrivate() ||
                in_array($property->getName(), $this->ignore) ||
                ($property->isProtected() && !$this->propertyHasGetter($property))
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    protected function propertyHasGetter(ReflectionProperty $property)
    {
        return method_exists($this, $this->propertyGetter($property));
    }

    /**
     * @param ReflectionProperty $property
     *
     * @return string
     */
    protected function propertyGetter(ReflectionProperty $property)
    {
        return 'get' . ucfirst($property->getName());
    }

    /**
     * @param ReflectionProperty $property
     *
     * @return mixed
     */
    protected function propertyValue(ReflectionProperty $property)
    {
        if ($this->propertyHasGetter($property)) {
            return $this->{$this->propertyGetter($property)}();
        }

        return $this->{$property->getName()};
    }

    /**
     * Get the instance properties as collection.
     *
     * @return Collection
     */
    public function collect(): Collection
    {
        try {
            $class = new ReflectionClass($this);
        } catch (ReflectionException $e) {
            return collect();
        }

        return collect($class->getProperties())
            ->reject(function (ReflectionProperty $property) {
                return $this->shouldIgnore($property);
            })
            ->mapWithKeys(function (ReflectionProperty $property) {
                return [$property->getName() => $this->propertyValue($property)];
            });

    }

}
