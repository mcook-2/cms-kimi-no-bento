<?php

include('../inc/config.inc.php');
include('../inc/check_login.inc.php');
include('../inc/database.inc.php');
include('../classes/form_validator.classes.php');
include('../classes/form_sanitizer.classes.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $sanitizedData = FormSanitizer::sanitize($_POST);
    $validator = new FormValidator($sanitizedData);

    // Validate form data
    $errors = $validator->validate();



    if (empty($errors)) {
        // Get the category ID based on the category name submitted
        $categoryName = $sanitizedData['category_name'];
        $stmt = $db->prepare("SELECT category_id FROM categories WHERE name = :category_name");
        $stmt->bindParam(':category_name', $categoryName);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);



        if ($category) {
            // Category exists, proceed with inserting the topic
            $categoryId = $category['category_id'];
            $title = $sanitizedData['topic_title'];
            $content = $sanitizedData['topic_content'];
            $topicStarterId = $_SESSION['user_id'];

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
    } else {
        // Form errors, redirect back to create topic page
        echo "Form not submitted.<br>";
        $_SESSION['errors'] = $errors;
        $_SESSION['submitted_data'] = $_POST; // Store submitted data in session
        header("Location: ../create_topic.php?error");
        exit();
    }
}

// If form is not submitted, redirect to index page
header("Location: ../index.php");
exit();
