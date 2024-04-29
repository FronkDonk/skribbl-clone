<?php

class Validator
{
    public function notEmpty()
    {
        return function ($data) {
            return !empty ($data) ? true : "Data cannot be empty";
        };
    }


    public function minLength($min)
    {
        return function ($data) use ($min) {
            return strlen($data) >= $min ? true : "Data is too short";
        };
    }

    public function maxLength($max)
    {
        return function ($data) use ($max) {
            return strlen($data) <= $max ? true : "Data is too long";
        };
    }

    public function email()
    {
        return function ($data) {
            return filter_var($data, FILTER_VALIDATE_EMAIL) ? true : "Data is not a valid email";
        };
    }

    public function in($values)
    {
        return function ($data) use ($values) {
            return in_array($data, $values) ? true : "Data is not in the allowed values";
        };
    }

    public function uuid()
    {
        return function ($data) {
            return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $data) ? true : "Data is not a valid UUID";
        };
    }

    public function intVal()
    {
        return function ($data) {
            return is_int($data) ? true : "Data is not an integer";
        };
    }

    public function stringType()
    {
        return function ($data) {
            return is_string($data) ? true : "Data is not a string";
        };
    }

    public function htmlspecialchars()
    {
        return function ($data) {
            return htmlspecialchars($data);
        };
    }
    public function validate($fields, $data)
    {
        $errors = [];
        foreach ($fields as $field => $rules) {
            foreach ($rules as $rule) {
                $result = $rule($data[$field]);
                if ($result !== true) {
                    $errors[$field] = $result;
                    break;
                }
            }
        }
        return $errors;
    }
}

