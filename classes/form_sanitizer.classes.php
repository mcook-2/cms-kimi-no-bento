<?php
class FormSanitizer extends FormValidator
{
    public static function sanitize($data)
    {
        $sanitizedData = [];

        foreach ($data as $key => $value) {
            switch ($key) {
                case 'email':
                    $sanitizedData[$key] = filter_var($value, FILTER_SANITIZE_EMAIL);
                    break;
                case 'url':
                    $sanitizedData[$key] = filter_var($value, FILTER_SANITIZE_URL);
                    break;
                case 'integer':
                    $sanitizedData[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                    break;
                case 'float':
                    $sanitizedData[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
                    break;
                default:
                    $sanitizedData[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $sanitizedData;
    }
}
