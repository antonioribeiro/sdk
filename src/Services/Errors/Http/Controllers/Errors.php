<?php

namespace PragmaRX\Sdk\Services\Errors\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

class Errors extends BaseController
{
    public function raise($number)
    {
        return view('errors.'.$number);
    }
}
