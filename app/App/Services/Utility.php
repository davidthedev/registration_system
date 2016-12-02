<?php

namespace App\Services;

class Utility
{
    /**
     * Convert value / string to camel case
     * @param  string $value value / string to convert
     * @return string        string, converted to camel case (e.g. new-post to newPost)
     */
    public static function convertToCamelCase($value)
    {
        $value = ucwords(str_replace('-', ' ', $value));
        return lcfirst(str_replace(' ', '', $value));
    }
}
