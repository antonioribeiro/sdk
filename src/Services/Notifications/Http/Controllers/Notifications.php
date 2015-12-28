<?php

namespace PragmaRX\Sdk\Services\Notifications\Http\Controllers;

use View;
use Session;
use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;

class Notifications extends BaseController
{
    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function index() {
        if (! Session::get('message')) {
            return Redirect::home();
        }

        return View::make('notifications.index')
                   ->with('title', Session::get('title'))
                   ->with('message', Session::get('message'))
                   ->with('buttons', Session::get('buttons'))
            ;
    }
}
