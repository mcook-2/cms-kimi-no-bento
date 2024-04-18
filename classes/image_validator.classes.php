<?php

class ImageValidator
{
    private $allowedMimeTypes;
    private $allowedFileExtensions;

    public function __construct()
    {
        $this->allowedMimeTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/bmp', 'image/webp'];
        $this->allowedFileExtensions = ['gif', 'jpg', 'jpeg', 'png', 'bmp', 'webp'];
    }

    public function isValidImage($image)
    {
        $actualFileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $actualMimeType = strtolower(mime_content_type($image['tmp_name']));

        $fileExtensionIsValid = in_array($actualFileExtension, $this->allowedFileExtensions);
        $mimeTypeIsValid = in_array($actualMimeType, $this->allowedMimeTypes);

        return $fileExtensionIsValid && $mimeTypeIsValid;
    }
}
