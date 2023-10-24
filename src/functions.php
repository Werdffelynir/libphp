<?php

use DI\Container;
use JetBrains\PhpStorm\NoReturn;
use \Lib\Core\Config;

function app(string $className, array $arguments = []): object
{
    if ($arguments) {
        return make($className, $arguments);
    }

    $container = new Container();

    return $container->get($className);
}

function make(string $className, array $arguments = []): object
{
    $container = new Container();
    $container->set($className, \DI\create()->constructor(...$arguments));

    return $container->get($className);
}

function config(string $name, ?string $directive = null)
{
    return Config::get($name, $directive);
}

#[NoReturn] function dd(...$arguments)
{
    var_dump(...$arguments);
    die;
}

function pp($argument): void
{
    $argumentString = print_r($argument, true);
    $argumentString = str_replace("(", "[", $argumentString);
    $argumentString = str_replace(")", "]", $argumentString);
    print_r($argumentString . "\n");
}

/**
 *  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
 *  origin.
 *
 *  In a production environment, you probably want to be more restrictive, but this gives you
 *  the general idea of what is involved.  For the nitty-gritty low-down, read:
 *
 *  - https://developer.mozilla.org/en/HTTP_access_control
 *  - https://fetch.spec.whatwg.org/#http-cors-protocol
 *
 */
function cors(): void
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}