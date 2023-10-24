<?php

namespace Lib\Core;

class Debug
{
    public static function pp($argument): void
    {
        $argumentString = print_r($argument, true);
        $argumentString = str_replace("(", "[", $argumentString);
        $argumentString = str_replace(")", "]", $argumentString);
        print_r($argumentString . "\n");
    }

    public static function dd(...$arguments)
    {
        var_dump(...$arguments);
        die;
    }

    public static function make(string $className, array $arguments = []): object
    {
        $container = new Container();
        $container->set($className, \DI\create()->constructor(...$arguments));

        return $container->get($className);
    }

    public static function app(string $className, array $arguments = []): object
    {
        if ($arguments) {
            return make($className, $arguments);
        }

        $container = new Container();

        return $container->get($className);
    }
}
