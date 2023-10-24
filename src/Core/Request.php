<?php

namespace Lib\Core;

class Request {

    public static function get($key = null, $default = ''){
        return $key
            ? $_GET[$key] ?? $default
            : $_GET ?? [];
    }

    public static function server($key = null){
        return $key
            ? $_SERVER[$key] ?? null
            : $_SERVER ?? [];
    }

    public static function post($key = null, $default = '')
    {
        $data = !empty($_POST) ? $_POST : (file_get_contents('php://input') ?? []);

        if (is_array($data)) {
            return $key ? ($data[$key] ?? $default) : $data;
        }

        try {
            $data = json_decode($data, true);
        } catch (\Exception $exception){
            $output = null;
            parse_str($data, $output);
            $data = !$output;
        }

        return $key ? ($data[$key] ?? $default) : $data;
    }

    public static function session($key = null, $value = '', $default = ''){
        if (session_status() !== \PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($key) && empty($value)) {
            return $_SESSION;
        }
        if (!empty($key) && empty($value)) {
            return $_SESSION[$key] ?? $default;
        }
        if (!empty($key) && !empty($value)) {
            return $_SESSION[$key] = $value;
        }

        return null;
    }

    public static function cookie($key = null, $value = '', $default = ''){
        if (empty($key) && empty($value)) {
            return $_COOKIE;
        }
        if (!empty($key) && empty($value)) {
            return $_COOKIE[$key] ?? $default;
        }
        if (!empty($key) && !empty($value)) {
            return $_COOKIE[$key] = $value;
        }

        return null;
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
     public static function cors(): void
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
}