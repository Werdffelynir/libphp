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
