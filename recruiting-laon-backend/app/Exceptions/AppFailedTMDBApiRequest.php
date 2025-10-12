<?php

namespace App\Exceptions;

use Exception;

class AppFailedTMDBApiRequest extends UnexpectedError { 
    public function __construct() {
        parent::__construct("Application failed to communicate with TMDB Api.");
    }
}