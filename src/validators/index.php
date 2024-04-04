<?php
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {
    public function validate($rules, $data) {
        $errors = [];

        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($data[$field]);
            } catch(NestedValidationException $e) {
                $errors[$field] = $e->getMessages();
            }
        }

        return $errors;
    }
}