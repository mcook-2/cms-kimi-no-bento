<?php
include("../lib/a/php-image-resize-master/lib/ImageResizeException.php");
include("../lib/a/php-image-resize-master/lib/ImageResize.php");

// Include the ImageValidator class
include_once("image_validator.classes.php"); // Make sure to provide the correct path

use Gumlet\ImageResize;
use Gumlet\ImageResizeException;

class ImageUploader
{
    private $uploadPath;

    public function __construct($upload_subfolder_name = 'uploads')
    {
        $this->uploadPath = ".." . DIRECTORY_SEPARATOR . $upload_subfolder_name;
    }

    public function uploadImage($image, $username)
    {
        // Instantiate the ImageValidator class
        $validator = new ImageValidator();

        // Check if the image is valid using the ImageValidator instance
        if ($validator->isValidImage($image)) {

            // Upload the image
            if ($this->moveImageToUploads($image, $username)) {

                return true; // Upload successful
            } else {
                // Handle image upload failure
                return false;
            }
        } else {
            // Handle invalid image
            return false;
        }
    }

    public function getImagePath($username, $imageName)
    {
        return $this->uploadPath . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR . $imageName;
    }

    private function moveImageToUploads($image, $username)
    {
        $userUploadPath = $this->uploadPath . DIRECTORY_SEPARATOR . $username;
        if (!file_exists($userUploadPath)) {
            mkdir($userUploadPath, 0777, true);
        }


        $imageFilename = $image['name'];
        $temporaryImagePath = $image['tmp_name'];
        $newImagePath = $userUploadPath . DIRECTORY_SEPARATOR . $imageFilename;

        if (move_uploaded_file($temporaryImagePath, $newImagePath)) {

            $this->resizeImage($newImagePath);
            return true; // Move successful
        } else {
            return false; // Failed to move uploaded file
        }
    }

    private function resizeImage($imagePath)
    {

        try {
            $image = new ImageResize($imagePath);
            // it works just fucks up and unsets all session and logs the user out

            $image->resizeToWidth(400);
            $mediumImagePath = dirname($imagePath) . DIRECTORY_SEPARATOR . basename($imagePath, '.' . pathinfo($imagePath, PATHINFO_EXTENSION)) . '_medium.' . pathinfo($imagePath, PATHINFO_EXTENSION);
            $image->save($mediumImagePath);

            $image = new ImageResize($imagePath);
            $image->resizeToWidth(50);
            $thumbnailImagePath = dirname($imagePath) . DIRECTORY_SEPARATOR . basename($imagePath, '.' . pathinfo($imagePath, PATHINFO_EXTENSION)) . '_thumbnail.' . pathinfo($imagePath, PATHINFO_EXTENSION);
            $image->save($thumbnailImagePath);
        } catch (ImageResizeException $e) {
            echo $e->getMessage();
        }
    }
}
