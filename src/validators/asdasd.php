<?php

/* class NestedValidationException extends Exception
{
    private $messages;

    public function __construct($messages, $code = 0, Exception $previous = null)
    {
        parent::__construct("", $code, $previous);
        $this->messages = $messages;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}

class Validator
{
    public function validate($rules, $data)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($data[$field]);
            } catch (NestedValidationException $e) {
                $errors[$field] = $e->getMessages();
            }
        }

        return $errors;
    }
}

class valid
{
    private $value;

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function assert($value, $fieldName)
    {
        if ($this->value !== $value) {
            throw new NestedValidationException(["Invalid value for $fieldName"]);
        }
    }



    public function notEmpty()
    {
        if (empty($this->value)) {
            throw new Exception('Value cannot be empty');
        }
        return $this;
    }

    public function stringType()
    {
        if (!is_string($this->value)) {
            throw new Exception('Value must be a string');
        }
        return $this;
    }

    public function email()
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }
        return $this;
    }

    public function uuid()
    {
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $this->value)) {
            throw new Exception('Invalid UUID');
        }
        return $this;
    }

    public function intVal()
    {
        if (!is_int($this->value)) {
            throw new Exception('Value must be an integer');
        }
        return $this;
    }

    public function in(array $choices)
    {
        if (!in_array($this->value, $choices, true)) {
            throw new Exception('Invalid value');
        }
        return $this;
    }
}


class v
{
    public static function notEmpty()
    {
        return (new valid())->notEmpty();
    }

    public static function stringType()
    {
        return (new valid())->stringType();
    }

    public static function email()
    {
        return (new valid())->email();
    }

    public static function uuid()
    {
        return (new valid())->uuid();
    }

    public static function intVal()
    {
        return (new valid())->intVal();
    }

    public static function in(array $choices)
    {
        return (new valid())->in($choices);
    }
} */
