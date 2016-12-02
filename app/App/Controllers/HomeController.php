<?php

namespace App\Controllers;

use App\Core\Config;

use App\View;
use App\Http\Request;
use App\Services\Redirect;
use App\Models\Session\Session;
use App\View\BaseView as BaseView;
use App\Controllers\BaseController as BaseController;

/**
 * Home controller handles user login / logout / registration and
 * simple about and contact pages
 */
class HomeController extends BaseController {

    /**
     * About page
     * @return void
     */
    public function about()
    {
        $this->view->render('home/about');
    }

    /**
     * Contact page
     * @return void
     */
    public function contact()
    {
        $this->view->render('home/contact');
    }

    /**
     * Landing / homepage / index page
     * If a visitor is not logged in redirect to login / signin page
     * otherwise to welcome page
     * @return void
     */
    public function index()
    {
        if (!$this->session->exists($this->userSession)) {
            Redirect::to('home/login');
        } else {
            Redirect::to('home/welcome');
        }
    }

    /**
     * Welcome page
     * If user is logged in display welcome message and account options
     * otherwise redirect to login page
     * @return void
     */
    public function welcome()
    {
        if ($this->session->exists($this->userSession)) {
            if (
                $user = $this->userService
                             ->getUser($this->session->get($this->userSession))
             ) {
                $welcomeMsg = $this->messageService->get('MESSAGE_WELCOME') .
                    $user->getFirstname();
            } else {
                $this->session->delete($this->session
                                             ->get($this->userSession));
                $this->session
                     ->add('message/failure', $this->messageService
                                                   ->get('MESSAGE_USER_NOT_FOUND'));
            }
            $this->view->render('home/welcome', [
                'data' => $this->session->getAll(),
                'message' => $welcomeMsg
                ]
            );
        } else {
            Redirect::to('home/login');
        }
    }

    /**
     * Landing / registration page
     * If user is not logged in display registration form and process
     * on submission otherwise redirect to welcome page
     * @return void
     */
    public function register()
    {
        if (!$this->session->exists($this->userSession)) {
            if (Request::check()) {
                if (
                    $this->verifyCsrfToken(
                        $this->csrfTokenName,
                        Request::getValue('token'))
                ) {
                    if ($this->userService->register(Request::get())) {
                        Redirect::to('home/login');
                    }
                }
            }
            $this->view->render('home/register', [
                'data' => $this->session->getAll(),
                'username' =>  Request::getValue('username'),
                'firstname' => Request::getValue('firstname'),
                'email' => Request::getValue('email'),
                'token' => $this->generateCsrfToken($this->csrfTokenName)]);
            return;
        } else {
            Redirect::to('home/welcome');
        }
    }

    /**
     * Login page
     * If user is not logged in dislay login form and process login
     * otherwise redirect to welcome page
     * @return void
     */
    public function login()
    {
        if (!$this->session->exists($this->userSession)) {
            if (Request::check()) {
                if (
                    $this->verifyCsrfToken(
                        $this->csrfTokenName,
                        Request::getValue('token')
                    )
                ) {
                    if ($user = $this->userService->login(Request::get())) {
                        $this->session->put('user', $user->getId());
                        $this->session->put('isLoggedIn', true);
                        $this->session->add('message/success',
                            $this->messageService->get('MESSAGE_LOGIN_SUCCESSFUL'));
                        Redirect::to('home/welcome');
                    }
                } else {
                    $this->session->add('message/failure',
                        $this->messageService->get('MESSAGE_CSRF_ERROR'));
                }
            }
            $this->view->render('home/login', [
                'data' => $this->session->getAll(),
                'token' => $this->generateCsrfToken($this->csrfTokenName)
                ]
            );
        } else {
            Redirect::to('home/welcome');
        }
    }

    /**
     * Logout route
     * Nothing to display here, just delete all user session data and
     * redirect to login page
     * @return void
     */
    public function logout()
    {
        $this->userService->logout();
        Redirect::to('home/login');
    }

    // update user details email, name
    public function update()
    {
        if (!$this->session->exists($this->userSession)) {
            Redirect::to('home/login');
        } else {
            $user = $this->userService
                         ->getUser($this->session->get($this->userSession));

            if (!empty(Request::check())) {
                if ($this->verifyCsrfToken($this->csrfTokenName, Request::getValue('token'))) {
                    if ($user = $this->userService->update($user->getId(), Request::get())) {
                        $this->session->add('message/success',
                            $this->messageService->get('MESSAGE_DETAILS_UPDATED'));
                    } else {
                        $this->session->add('message/failure',
                            $this->messageService->get('MESSAGE_DETAILS_ERROR'));
                    }
                }
            }

            $this->view->render('home/update',
                [   'data' => $this->session->getAll(),
                    'firstname' => $user->getFirstname(),
                    'email' => $user->getEmail(),
                    'token' => $this->generateCsrfToken($this->csrfTokenName)]);
        }
    }

    public function password()
    {
        if (!$this->session->exists($this->userSession)) {
            Redirect::to('home/login');
        } else {
            $user = $this->userService
                         ->getUser($this->session->get($this->userSession));

            if (!empty(Request::check())) {
                if ($this->verifyCsrfToken($this->csrfTokenName, Request::getValue('token'))) {
                    if ($user = $this->userService
                                     ->updatePassword($user->getId(), Request::get())) {
                        $this->session->add('message/success',
                            $this->messageService->get('MESSAGE_PASSWORD_UPDATED'));
                    } else {
                        $this->session->add('message/failure',
                            $this->messageService->get('MESSAGE_CSRF_ERROR'));
                    }
                }
            }

            $this->view->render('home/password',
                [   'token' => $this->generateCsrfToken($this->csrfTokenName),
                    'data' => $this->session->getAll()]
            );
        }
    }


}
