<?php

namespace App\Services;

use FINFO;
use Exception;
use App\Domain\User\UsernameUnique;
use App\Domain\User\UserRepositoryInterface;

/**
 * Validation service class validates data by accepting an array of data
 * and another array of rules to validate this data against. It is recommended to
 * wrap 'validate' function in a try catch block as it throws error on first incorrect
 * data type (e.g. if a rule is 'required' and there is no dta submitted throws an error)
 */
class ValidationService  {

    protected $rules = [];
    protected $fields = [];
    protected $errors = [];
    protected $validatedData = [];

    public function validate(array $data, array $rulesAndFields)
    {
        foreach ($rulesAndFields as $field => $expecteds) {
            // build an array of rules
            $rulesAndValues = explode(',', $expecteds);
            foreach ($rulesAndValues as $key => $rule) {
                $value = explode('=', $rule);
                // if there are values to compare rule against
                // e.g. 'max_length=10'
                if (count($value) > 1) {
                    // method name e.g. 'max_length' becomes validateMaxLength
                    $ruleMethodName = 'validate' .
                        str_replace(' ', '', (ucwords(str_replace('_', ' ', $value[0]))));
                    // value to compare against e.g. '10'
                    $value = $value[1];
                } else {
                    // method name e.g. 'required' becomes validateRequired
                    $ruleMethodName = 'validate' .
                        str_replace(' ', '', (ucwords(str_replace('_', ' ', $value[0]))));
                    // can add password match here
                    $value = $data[$field];
                }
                if (!call_user_func_array([$this, $ruleMethodName],
                    [$field, $data[$field], $value])) {
                    $this->generateError($ruleMethodName, $field, $value);
                    throw new Exception($this->getAllValidationErrors()[0]);
                } else {
                    $this->validatedData[$field] = $data[$field];
                }
            }
        }
        return $this;
    }

    protected function generateError($rule, $field, $expected)
    {
        switch ($rule) {
            case 'validateRequired':
                $this->errors[] = $field . ' must not be empty';
                break;
            case 'validateMaxLength':
                $this->errors[] = $field . ' must not be more that ' .
                    $expected . ' characters long';
                break;
            case 'validateMinLength':
                $this->errors[] = $field . ' must not be less that ' .
                    $expected . ' characters';
                break;
            case 'validateAlphaNum':
                $this->errors[] = $field . ' must contain only numbers and letters';
                break;
            case 'validateUnique':
                $this->errors[] = $field . ' has already been taken';
                break;
            case 'validateMatch':
                $this->errors[] = 'passwords do not match';
                break;
            case 'validateMaxSize':
                $this->errors[] = 'File is more than the allowed ' . $excepted . ' size.';
                break;
            case 'validateExtension':
                $this->errors[] = 'File type is not allowed.';
                break;
            default:
                $this->errors[] = $field . ' is invalid';
                break;
        }
    }

    public function hasErrors()
    {
        return (!empty($this->errors)) ? true : false;
    }

    public function getAllValidationErrors()
    {
        return $this->errors;
    }

    public function getValidatedData()
    {
        return $this->validatedData;
    }

    protected function validateRequired($field, $input, $expected = null)
    {
        return !empty($input) ? true : false;
    }

    protected function validateMaxLength($field, $input, $expected)
    {
        return mb_strlen($input) <= $expected ? true : false;
    }

    protected function validateMinLength($field, $input, $expected)
    {
        return mb_strlen($input) >= $expected ? true : false;
    }

    protected function validateAlphaNum($field, $input, $expected = null)
    {
        return ctype_alnum($input) === true ? true : false;
    }

    protected function validateAlpha($field, $input, $expected = null)
    {
        return ctype_alpha($input) === true ? true : false;
    }

    protected function validateMatch($field, $input, $expected)
    {
        return $input == $expected ? true : false;
    }

    protected function validateMaxSize($field, $input, $expected)
    {
        return filesize($input) < $expected ? true : false;
    }

    protected function validateExtension($field, $input, $expected)
    {
        $imageFile = getimagesize($input);
        if ($imageFile) {
            if ($imageFile['mime'] == 'image/' . $expected) {
                return true;
            }
        }
        return false;
    }

    protected function validateEmail($field, $input, $expected = null)
    {
        return !empty($input) ? true : false;
    }
}
