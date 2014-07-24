<?php

use RyanNielson\Prez\PresenterFinder;

if (!function_exists('presenter'))
{
    function presenter($object, $klass = null)
    {
        return (new PresenterFinder($object, $klass))->presenter();
    }
}
