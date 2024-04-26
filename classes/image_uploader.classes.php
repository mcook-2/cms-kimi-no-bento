<?php
include("../lib/a/php-image-resize-master/lib/ImageResizeException.php");
include("../lib/a/php-image-resize-master/lib/ImageResize.php");
include_once("../inc/config.inc.php");

include_once("image_validator.classes.php");

// img resize lib
use Gumlet\ImageResize;
use Gumlet\ImageResizeException;

class ImageUploader
{
    private $uploadPath;
    private $uploadPathTopic;


    public function __construct($upload_subfolder_name = 'uploads')
    {
        $this->uploadPath = "../"  . $upload_subfolder_name;
        $this->uploadPathTopic =  $upload_subfolder_name;
    }

    public function uploadImage($image, $username)
    {

        $validator = new ImageValidator();

        // Check if the image is valid using ImageValidator 
        if ($validator->isValidImage($image)) {

            // Upload the image
            if ($this->moveImageToUploads($image, $username)) {
                return true; // Upload successful
            } else {
                // image upload failure
                return false;
            }
        } else {
            // invalid image
            return false;
        }
    }

    //get img path (use for database insert/update)
    public function getImagePath($username, $imageName, $isTopic)
    {
        $uploadPath = $isTopic ? $this->uploadPathTopic : $this->uploadPath;
        return $uploadPath . '/' . $username . '/' . $imageName;
    }

    private function moveImageToUploads($image, $username)
    {
        $userUploadPath = $this->uploadPath . DIRECTORY_SEPARATOR . $username;

        // User uploads are stored in directories named after their usernames
        if (!file_exists($userUploadPath)) {
            mkdir($userUploadPath, 0777, true);
        }

        $imageFilename = $image['name'];
        $temporaryImagePath = $image['tmp_name'];
        $newImagePath = $userUploadPath . DIRECTORY_SEPARATOR . $imageFilename;

        if (move_uploaded_file($temporaryImagePath, $newImagePath)) {
            $this->resizeImage($newImagePath);
            if (file_exists($newImagePath)) {
                echo "File successfully moved to destination: " . $newImagePath;
            } else {
                echo "File was not found at destination: " . $newImagePath;
            }
            return true; // Move successful
        } else {
            return false; // Failed to move uploaded file
        }
    }


    private function resizeImage($imagePath)
    {
        // resize orginal img, overwirte with same name
        try {
            $image = new ImageResize($imagePath);
            $image->resizeToWidth(200);
            $image->resizeToHeight(200);
            $thumbnailImagePath = dirname($imagePath) . DIRECTORY_SEPARATOR . basename($imagePath, '.' . pathinfo($imagePath, PATHINFO_EXTENSION)) . '.'   . pathinfo($imagePath, PATHINFO_EXTENSION);
            $image->save($thumbnailImagePath);
        } catch (ImageResizeException $e) {
            echo $e->getMessage();
        }

        // thumbnail resize
        try {
            $image = new ImageResize($imagePath);
            $image->resizeToWidth(100);
            $image->resizeToHeight(100);
            $thumbnailImagePath = dirname($imagePath) . DIRECTORY_SEPARATOR . basename($imagePath, '.' . pathinfo($imagePath, PATHINFO_EXTENSION)) . '_thumbnail.' . pathinfo($imagePath, PATHINFO_EXTENSION);
            $image->save($thumbnailImagePath);
        } catch (ImageResizeException $e) {
            echo $e->getMessage();
        }
    }
}
