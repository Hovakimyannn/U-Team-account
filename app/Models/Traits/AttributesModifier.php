<?php

declare(strict_types = 1);

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait AttributesModifier
{
    /**
     * Get an attribute from the model.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key) : mixed
    {
        if (method_exists($this, $key)) {
            return parent::getAttribute($key);
        }

        return parent::getAttribute(Str::snake($key));
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setAttribute($key, $value) : mixed
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray() : array
    {
        $array = parent::toArray();
        $camelArray = [];
        foreach ($array as $name => $value) {
            $camelArray[Str::camel($name)] = $value;
        }

        return $camelArray;
    }
}
