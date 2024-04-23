<?php
include('../inc/config.inc.php');
include('../inc/database.inc.php');
include('../classes/form_validator.classes.php');
include('../classes/form_sanitizer.classes.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instantiate the FormValidator class with the sanitized data
    $sanitizedData = FormSanitizer::sanitize($_POST);
    $validator = new FormValidator($sanitizedData);



    // Validate the form fields
    $errors = $validator->validate();

    $post_id = $sanitizedData['post_id'] ?? null;
    $topic_id = $sanitizedData['topic_id'] ?? null;

    $redirect_id = isset($post_id) ? "post_id=$post_id" : "topic_id=$topic_id";


    // Check if there are no validation errors
    if (empty($errors)) {
        // Check if it's a post update or topic update based on the submitted fields
        if (isset($sanitizedData['post_title']) && isset($sanitizedData['post_content'])) {
            // Handle post update
            $post_title = $sanitizedData['post_title'];
            $post_content = $sanitizedData['post_content'];


            $stmt = $db->prepare("UPDATE posts SET title = :post_title, content = :post_content WHERE post_id = :post_id");
            $stmt->bindParam(':post_title', $post_title, PDO::PARAM_STR);
            $stmt->bindParam(':post_content', $post_content, PDO::PARAM_STR);
            $stmt->bindParam(':post_id', $sanitizedData['post_id'], PDO::PARAM_INT);
            if ($stmt->execute()) {
                header("location: ../user/view_all_posts.php?update=true");
                exit();
            } else {
                header("location: ../user/view_all_posts.php?update=false");
                exit();
            }
        } elseif (isset($sanitizedData['category_name']) && isset($sanitizedData['topic_title']) && isset($sanitizedData['topic_content'])) {

            $category_name = $sanitizedData['category_name'];
            $topic_title = $sanitizedData['topic_title'];
            $topic_content = $sanitizedData['topic_content'];

            $categoryStmt = $db->prepare("SELECT category_id FROM categories WHERE name = :category_name");
            $categoryStmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
            $categoryStmt->execute();
            $categoryResult = $categoryStmt->fetch(PDO::FETCH_ASSOC);

            // Check if category exists
            if ($categoryResult) {
                $category_id = $categoryResult['category_id'];

                // Update the topic in the database
                $updateStmt = $db->prepare("UPDATE topics SET title = :topic_title, topic_content = :topic_content, category_id = :category_id WHERE topic_id = :topic_id");
                $updateStmt->bindParam(':topic_title', $topic_title, PDO::PARAM_STR);
                $updateStmt->bindParam(':topic_content', $topic_content, PDO::PARAM_STR);
                $updateStmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                $updateStmt->bindParam(':topic_id', $sanitizedData['topic_id'], PDO::PARAM_INT);

                if ($updateStmt->execute()) {
                    header("location: ../user/view_all_posts.php?update=true");
                    exit();
                } else {
                    header("location: ../user/view_all_posts.php?update=false");
                    exit();
                }
            } else {
                // Handle invalid form fields
                echo "Error: Invalid form fields.";
                header("location: ../user/view_all_posts.php?update=false");
                exit();
            }
        } else {
            // Output validation errors
            $_SESSION['errors'] = $errors;
            header("location: ../user/user_edit.php?$redirect_id"); // Redirect back to the registration form
            exit();
        }
    } else {
        // Handle invalid request method
        echo "Error: Invalid request method.";
    }
}
