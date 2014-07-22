<?php

use Illuminate\Support\Facades\Route;
use RyanNielson\Heimdall\Heimdall;

if (!function_exists('present'))
{
    function present($object, $method)
    {
        return (new PresenterFinder($object))->presenter();
    }
}
