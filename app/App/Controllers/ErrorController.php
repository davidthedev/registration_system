<?php

namespace App\Controllers;

use App\View\BaseView as BaseView;
use App\Controllers\BaseController as BaseController;

/**
 * Error controller class handles non-existent routes by
 * rendering error / 404 template page
 */
class ErrorController extends BaseController {

    public function index()
    {
        $this->view->render('error/404', []);
    }
}
