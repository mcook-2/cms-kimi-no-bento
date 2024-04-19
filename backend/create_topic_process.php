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
        $title = $sanitizedData["topic_title"];
        $topic_content = $sanitizedData["topic_content"];
        $category_type = $sanitizedData["category_type"];
        $new_category_name = $sanitizedData["new_category_name"];
        $existing_category_id = $sanitizedData["existing_category_id"];
        $topic_starter_id = $_SESSION['user_id'];

        // Handle new category insertion
        if ($category_type === "new") {
            $stmt = $db->prepare("INSERT INTO categories (name, user_id) VALUES (:new_category_name, :user_id)");
            $stmt->bindParam(':new_category_name', $new_category_name, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $topic_starter_id, PDO::PARAM_INT);
            $stmt->execute();

            // Get the newly inserted category ID
            $category_id = $db->lastInsertId();
        } else { // Existing category
            $category_id = $existing_category_id;
        }

        // Check if the category ID exists
        $stmt = $db->prepare("SELECT COUNT(*) FROM categories WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Insert the topic into the database
            $stmt = $db->prepare("INSERT INTO topics (category_id, title, topic_content, topic_starter_id) VALUES (:category_id, :title, :topic_content, :topic_starter_id)");
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':topic_content', $topic_content, PDO::PARAM_STR);
            $stmt->bindParam(':topic_starter_id', $topic_starter_id, PDO::PARAM_INT);
            $stmt->execute();

            $topic_id = $db->lastInsertId();

            // Redirect user to the topic page after successfully submitting the post
            echo "Topic inserted into the database successfully. Redirecting to the topic page...<br>";
            unset($_SESSION['submitted_data']);
            header("Location: ../show_topic.php?topic_id=$topic_id");
            exit();
        } else {
            echo "Category does not exist.";
        }
    } else {
        echo "Form not submitted.<br>";
        $_SESSION['errors'] = $errors;
        $_SESSION['submitted_data'] = $_POST; // Store submitted data in session
    }
}

header("Location: ../index.php");
exit();
