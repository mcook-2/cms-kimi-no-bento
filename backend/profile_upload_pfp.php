<?php
include_once('../inc/config.inc.php');
include('../inc/check_login.inc.php');
include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/image_validator.classes.php');
include('../classes/image_uploader.classes.php');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in

    // Get user ID and username from session
    $user_id = $_SESSION["user_id"];
    $username = $_SESSION["username"];


    // Check if a profile picture has been uploaded
    if (!isset($_FILES["profilePicture"]) || empty($_FILES["profilePicture"]["name"])) {
        // If the file input field does not exist or the filename is empty, no file was uploaded
        header("location: ../user/account.php?error=no_profile_picture");
        exit;
    }

    // Get profile picture file name


    // Create instances of ImageUploader and ProfileInfo classes
    $imageUploader = new ImageUploader();
    $profileInfo = new ProfileInfo();


    $profilePicture = $_FILES["profilePicture"]["name"];

    // Get the image path using the ImageUploader's getImagePath method
    $imagePath = $imageUploader->getImagePath($username, $profilePicture);

    // Upload the profile picture
    if (!$imageUploader->uploadImage($_FILES["profilePicture"], $username)) {


        // If upload failed, redirect to the account page with an error message
        header("location: ../user/account.php?error=upload_failed");
        exit;
    }

    // Update the profile picture path in the database
    if (!$profileInfo->updateProfilePfp($imagePath, $user_id)) {
        // If update failed, redirect to the account page with an error message
        header("location: ../user/account.php?error=update_failed");
        exit;
    }

    // If both update and upload are successful, redirect to the account page with no error
    header("location: ../user/account.php?error=none");
    exit;
} else {
    // If the form was not submitted via POST, redirect to the account page
    header("location: ../user/account.php");
    exit;
}
