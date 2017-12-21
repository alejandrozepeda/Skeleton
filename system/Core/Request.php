<?php

namespace System\Core;

class Request
{
    public static function uri()
    {
        return trim(
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
            ) . '/';
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'] === 'HEAD' ? 'GET' : $_SERVER['REQUEST_METHOD'];
    }

    public static function validate($params)
    {
        $errors = [];

        foreach ($params as $name => $validations) {
            foreach (explode('|', $validations) as $validation) {

                $input = filter_input(INPUT_POST, $name);
                $error = false;

                switch ($validation) {
                    case 'boolean':
                        if (!filter_var($input, FILTER_VALIDATE_BOOLEAN)) {
                            $error = true;
                        }
                        break;
                    case 'int':
                        if (!filter_var($input, FILTER_VALIDATE_INT)) {
                            $error = true;
                        }
                        break;
                    case 'email':
                        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                            $error = true;
                        }
                        break;
                    case 'url':
                        if (!filter_var($input, FILTER_VALIDATE_URL)) {
                            $error = true;
                        }
                        break;
                    case 'string':
                        if (!is_string($input)) {
                            $error = true;
                        }
                        break;
                    case 'required':
                        if (empty($input)) {
                            $error = true;
                        }
                        break;
                    case 'array':
                        if (!is_array($input)) {
                            $error = true;
                        }
                        break;
                }

                if ($error) {
                    $errors[] = [
                        'name' => $name,
                        'validation' => $validation
                    ];
                }

            }
        }

        return $errors;
    }
}
