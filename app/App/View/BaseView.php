<?php

namespace App\View;

use App\Services\Session;
use App\Core\Config;

/**
 * BaseView class renders and messages views for pages
 */
class BaseView {

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function render($view, $args = [])
    {
        $viewLocation = __DIR__ . '/../View/';
        // [0] - view folder, [1] - template name
        $viewPath = explode('/', $view);
        // normally $data - session data, $message - various messages
        extract($args);

        $messages = isset($data['message']) ? $data['message'] : [];
        if (!empty($messages)) {
            $messages = $this->renderMessages($data['message']);
        }

        // render header
        $this->renderHeader();
        // render body
        require $viewLocation . ucfirst($viewPath[0]) . '/' . strtolower($viewPath[1]) . '.php';
        // render footer
        $this->renderFooter();
    }

    private function renderMessages($messages)
    {
        $messageBag = [];

        foreach ($messages as $key => $value) {
            if ($key == 'failure') {
                foreach ($messages[$key] as $message) {
                    $messageBag[] = '<div class="message failure">' . $message . '</div>';
                }
            } elseif ($key == 'success') {
                foreach ($messages[$key] as $key => $message) {
                    $messageBag[] = '<div class="message success">' . $message . '</div>';
                }
            } elseif ($kye == 'message') {
                foreach ($messages[$key] as $key => $message) {
                    $messageBag[] = '<div class="message">' . $message . '</div>';
                }
            }
        }

        $this->session->delete('message');
        $this->session->delete('failure');

        return $messageBag;
    }

    private function renderHeader()
    {
        // render log in / log out / register section
        if ($this->session->get('isLoggedIn')) {
            $logInMenu = '<ul><li><a href="' . Config::get('URL') . 'home/logout' . '">Sign out</a></li></ul>';
            $memberArea = '<li><a href="' . Config::get('URL') . 'home/index' . '">Member Area</a></li>';
        } else {
            $logInMenu = '
                <ul>
                    <li><a href="' . Config::get('URL') . 'home/login' . '">Sign in</a></li>
                    <li><a href="' . Config::get('URL') . 'home/register' . '">Register</a></li>
                </ul>';
            $memberArea = '';
        }
        $url = Config::get('URL');
        require Config::get('VIEWS') . 'Includes/header.php';
    }

    public function renderFooter()
    {
        require Config::get('VIEWS') . 'Includes/footer.php';
    }
}
