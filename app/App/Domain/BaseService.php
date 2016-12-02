<?php

namespace App\Domain;

use Exception;
use App\Services\Message;
use App\Services\Session;
use App\Database\PdoAdapter;
use App\Services\ValidationService;
use App\Services\SanitizationService;

abstract class BaseService {

    protected $message;
    protected $session;
    protected $database;
    protected $userService;
    protected $validationService;
    protected $sanitizationService;

    public function __construct()
    {
        $this->database = new PdoAdapter;
        $this->validationService = new ValidationService;
        $this->sanitizationService = new SanitizationService;
        $this->message = new Message;
        $this->session = new Session;
    }
}
