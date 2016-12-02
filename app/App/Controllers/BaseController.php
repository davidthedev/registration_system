<?php

namespace App\Controllers;

use App\Core\Config;
use App\View\BaseView;
use App\Services\Csrf;
use App\Services\Session;
use App\Services\Message;
use App\Domain\User\UserService;

/**
 * Base controller class. Other controllers extend this abstract BaseController class.
 * Several things happen upon controller creation:
 * 1. A new session is started
 * 2. View class which renders page view is initialised
 * 3. User service class which handles user login and registration is initialised
 * 4. Messaging service class which contains message text for various purposes is initialised
 * 5. Csrf (Cross Site Request Forgery) trait is used which handles special token
 * creation and verification
 */
abstract class BaseController {

    use Csrf;

    protected $view;
    protected $config;
    protected $session;
    protected $userSession;
    protected $userService;
    protected $message = [];
    protected $csrfTokenName;
    protected $messageService;
    protected $routeParams = [];

    public function __construct($routeParams = [])
    {
        $this->session = new Session;
        $this->session->start();
        $this->view = new BaseView($this->session, $this->config);
        $this->userSession = Config::get('SESSION_NAME');
        $this->csrfTokenName = Config::get('CSRF_TOKEN_NAME');
        $this->userService = new UserService;
        $this->routeParams = $routeParams;
        $this->messageService = new Message;
    }
}
