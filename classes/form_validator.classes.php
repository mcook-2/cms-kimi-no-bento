<?php

class FormValidator
{
    private $data;
    private $requiredFields = [];
    private $errors = [];

    public function __construct($postData)
    {
        $this->data = $postData;
    }

    public function validate()
    {
        // Reset errors array
        $this->errors = [];

        try {
            if (isset($this->data['required_fields'])) {
                try {
                    $this->validateRequiredFields();
                } catch (Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }

            if (isset($this->data['email'])) {
                try {
                    $this->validateEmailFormat();
                } catch (Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }

            if (isset($this->data['password'])) {
                try {
                    $this->validatePasswordStrength();
                } catch (Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }

            if (isset($this->data['username'])) {
                try {
                    $this->validateUsernameFormat();
                } catch (Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }

            if (isset($this->data['password']) && isset($this->data['confirm_password'])) {
                try {
                    $this->validateConfirmPassword();
                } catch (Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }

            if (isset($this->data['reply_title'])) {
                try {
                    $this->validateReplyTitle();
                } catch (Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }

            if (isset($this->data['reply_title'])) {
                try {
                    $this->validateReplyContent();
                } catch (Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }



        return $this->errors;
    }


    public function setRequiredFields($fields)
    {
        $this->requiredFields = $fields;
    }


    // Updated validation methods in FormValidator class

    private function validateRequiredFields()
    {
        // Check if required fields are present
        foreach ($this->requiredFields as $field) {
            if (empty($this->data[$field])) {
                throw new Exception("{$field}: is required");
            }
        }
    }

    private function validateEmailFormat()
    {
        // Check if email field is in a valid format
        if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("email: Invalid email format");
        }
    }

    private function validatePasswordStrength()
    {
        // Check if password meets strength requirements
        $password = $this->data['password'];
        if (strlen($password) < 8) {
            throw new Exception("password: Password must be at least 8 characters long");
        }
        if (!preg_match('/[A-Z]/', $password)) {
            throw new Exception("password: Password must contain at least one uppercase letter");
        }
        if (!preg_match('/[a-z]/', $password)) {
            throw new Exception("password: Password must contain at least one lowercase letter");
        }
        if (!preg_match('/[0-9]/', $password)) {
            throw new Exception("password: Password must contain at least one number");
        }
    }

    private function validateUsernameFormat()
    {
        // Check if username follows format rules
        $username = $this->data['username'];
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            throw new Exception("username: Username can only contain letters, numbers, and underscores");
        }
    }

    private function validateConfirmPassword()
    {
        // Check if confirm password matches password
        $password = $this->data['password'];
        $confirmPassword = $this->data['confirm_password'];
        if ($password !== $confirmPassword) {
            throw new Exception("confirm_password: Passwords do not match");
        }
    }



    // for post reply 

    private function validateReplyTitle()
    {
        // Check if reply title is empty or too long
        $reply_title = $this->data['reply_title'];
        if (empty($reply_title)) {
            throw new Exception("reply_title: Reply title is required");
        }
        if (strlen($reply_title) > 255) {
            throw new Exception("reply_title: Reply title must be less than 255 characters");
        }
    }

    private function validateReplyContent()
    {
        // Check if reply content is empty
        $reply_content = $this->data['reply_content'];
        if (empty($reply_content)) {
            throw new Exception("reply_content: Reply content is required");
        }
    }
}
