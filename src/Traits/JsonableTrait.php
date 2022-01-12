<?php

namespace Maduser\Laravel\Support\Traits;

trait JsonableTrait
{
    use ArrayableTrait;

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     * @throws ReflectionException
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @throws ReflectionException
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
