<?php

/**
 * Base PHP
 *
 * @author   Nisa Delgado <nisadelgado@gmail.com>
 */
include 'vendor/autoload.php';

if ($_SERVER['REQUEST_SCHEME'] == 'http') {
    redirect('https://api.sportstvrights.com');
}

App::run();
