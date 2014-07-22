<?php

use RyanNielson\Prez\PresenterFinder;

if (!function_exists('present'))
{
    function presenter($object, $klass = null)
    {
        return (new PresenterFinder($object, $klass))->presenter();
    }
}
