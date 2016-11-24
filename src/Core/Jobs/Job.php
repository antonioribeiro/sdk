<?php

namespace PragmaRX\Sdk\Core\Jobs;

use Illuminate\Bus\Queueable;

abstract class Job
{
    use Queueable;

    public function __construct($properties = null)
    {
        $this->loadProperties($properties);
    }

    private function loadProperties($properties = [])
    {
        if (! $properties)
        {
            return false;
        }

        foreach ($properties as $key => $value)
        {
            $key = studly($key);

            $property = property_exists($this, $key)
                        ? $key
                        : (property_exists($this, camel($key)) ? camel($key) : null);

            if ($property) {
                $this->{$property} = $value;
            }
        }
    }

    public function getPublicProperties()
    {
        return get_object_vars($this);
    }
}
