<?php
include('../inc/config.php');
include('../inc/database.php');
include('../backend/form_validator.php');

// Check if the user is logged in
if (!isLoggedIn()) {
    // Redirect the user to the login page if not logged in
    header("Location: user/login.php");
    exit();
}

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instantiate FormValidator with POST data

    $title = $_POST['title'];
    $content = $_POST['content'];
    $thread_id = $_POST['thread_id'];
    $validator = new FormValidator($_POST);

    // Validate form data
    $errors = $validator->validate();

    if (empty($errors)) {
        // If there are no validation errors, proceed with further processing

        // Retrieve data from form submission


        // Insert post into database
        try {
            $insert_post_query = "INSERT INTO posts (thread_id, user_id, title, content) 
                                  VALUES (:thread_id, :user_id, :title, :content)";
            $insert_post_statement = $db->prepare($insert_post_query);
            $insert_post_statement->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
            $insert_post_statement->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $insert_post_statement->bindParam(':title', $title, PDO::PARAM_STR);
            $insert_post_statement->bindParam(':content', $content, PDO::PARAM_STR);
            $insert_post_statement->execute();

            // Redirect back to the thread page or display a success message
            header("Location: ../showthread.php?thread_id=" . $thread_id);
            exit();
        } catch (PDOException $e) {
            // Handle database error
            echo "Error: " . $e->getMessage();
        }
    } else {
        // If there are validation errors, store errors in session and redirect back to the form page
        $_SESSION['errors'] = $errors;
        header("Location: ../showthread.php?thread_id=" . $thread_id); // Redirect back to the form page
        exit();
    }
}
