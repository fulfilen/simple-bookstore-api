<?php 

namespace App\Validation;
use Respect\Validation\Exceptions\ValidationException;

class Validator
{
    protected $errors = [];

    public function validate($req, $rules = [])
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->check($req->getParam($field));
            } catch (ValidationException $e) {
                $this->errors[$field] = $e->getMainMessage();
            }
        }

        return $this;
    }

    public function failed()
    {
        return !empty($this->getErrors());
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
