<?php

namespace App\Services;

use App\Core\Config;

/**
 * Redirect class redirects request to specified routes / locations
 */
class Redirect {
    public static function to($location = null)
    {
        if ($location != null) {
            header("Location: " . Config::get('URL') . $location);
            exit();
        }
    }
}
