<?php
include('../inc/config.inc.php');
include('../inc/check_login.inc.php');
include('../inc/database.inc.php');

include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/form_validator.classes.php');
include('../classes/form_sanitizer.classes.php');
include('../classes/image_uploader.classes.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION["username"];
    $sanitizedData = FormSanitizer::sanitize($_POST);
    $validator = new FormValidator($sanitizedData);
    // Validate form data
    $errors = $validator->validate();

    if (empty($errors)) {
        // Check if an image was uploaded
        if (!empty($_FILES['topic_image']['name'])) {

            $imageUploader = new ImageUploader();
            $imageValidator = new ImageValidator();

            // Check if the uploaded image is valid
            if (!$imageValidator->isValidImage($_FILES['topic_image'])) {
                // Image is not valid, set an error and redirect back
                $_SESSION['errors'][] = "Invalid image format or size.";
                header("Location: ../create_topic.php?error");
                exit();
            }

            // Image is valid, proceed with topic insertion
            // Get the category ID based on the category name submitted
            $categoryName = $sanitizedData['category_name'];
            $stmt = $db->prepare("SELECT category_id FROM categories WHERE name = :category_name");
            $stmt->bindParam(':category_name', $categoryName);
            $stmt->execute();
            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the category exists
            if ($category) {
                // Category exists, proceed with inserting the topic
                $categoryId = $category['category_id'];
                $title = $sanitizedData['topic_title'];
                $content = $sanitizedData['topic_content'];
                $topicStarterId = $_SESSION['user_id'];

                // Upload the image
                if ($imageUploader->uploadImage($_FILES['topic_image'], $_SESSION['username'])) {
                    // Image upload successful, retrieve the image filename
                    $imageName = $_FILES['topic_image']['name'];

                    $profileInfo = new ProfileInfo();

                    $imagePath = $imageUploader->getImagePath($username,  $imageName,  $isTopic = true);
                } else {
                    // Image upload failed, redirect back with error
                    $_SESSION['errors'][] = "Failed to upload image.";
                    header("Location: ../create_topic.php?errorimg");
                    exit();
                }

                // Insert topic data into the database
                $stmt = $db->prepare("INSERT INTO topics (category_id, title, topic_content, topic_starter_id, img_url) VALUES (:category_id, :title, :topic_content, :topic_starter_id, :image)");
                $stmt->bindParam(':category_id', $categoryId);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':topic_content', $content);
                $stmt->bindParam(':topic_starter_id', $topicStarterId);
                $stmt->bindParam(':image', $imagePath);
                $stmt->execute();
                $topicId = $db->lastInsertId();

                // Redirect to index page after successful insertion
                header("Location: ../show_topic.php?topic_id=$topicId");
                exit();
            } else {
                // Category does not exist
                echo "Category does not exist.";
            }
        } else {
            // No image uploaded, proceed without image
            // Get the category ID based on the category name submitted

            $categoryName = $sanitizedData['category_name'];
            $stmt = $db->prepare("SELECT category_id FROM categories WHERE name = :category_name");
            $stmt->bindParam(':category_name', $categoryName);
            $stmt->execute();
            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the category exists
            if ($category) {
                // Category exists, proceed with inserting the topic
                $categoryId = $category['category_id'];
                $title = $sanitizedData['topic_title'];
                $content = $sanitizedData['topic_content'];
                $topicStarterId = $_SESSION['user_id'];

                // Insert topic data into the database
                $stmt = $db->prepare("INSERT INTO topics (category_id, title, topic_content, topic_starter_id) VALUES (:category_id, :title, :topic_content, :topic_starter_id)");
                $stmt->bindParam(':category_id', $categoryId);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':topic_content', $content);
                $stmt->bindParam(':topic_starter_id', $topicStarterId);
                $stmt->execute();
                $topicId = $db->lastInsertId();

                // Redirect to index page after successful insertion
                header("Location: ../show_topic.php?topic_id=$topicId");
                exit();
            } else {
                // Category does not exist
                echo "Category does not exist.";
            }
        }
    } else {
        // Form errors, redirect back to create topic page
        $_SESSION['errors'] = $errors;
        $_SESSION['submitted_data'] = $_POST; // Store submitted data in session
        header("Location: ../create_topic.php?error");
        exit();
    }
}

// If form is not submitted, redirect to index page
header("Location: ../index.php");
exit();
