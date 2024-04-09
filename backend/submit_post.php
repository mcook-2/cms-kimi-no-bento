<?php
include('../inc/config.inc.php');
include('../inc/database.inc.php');
include('../classes/form_validator.classes.php');
include('../classes/form_sanitizer.classes.php');

// Check if the user is logged in
if (!isLoggedIn()) {
    // Redirect the user to the login page if not logged in
    header("Location: user/login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $sanitizedData = FormSanitizer::sanitize($_POST);

    $validator = new FormValidator($sanitizedData);

    // Validate form data
    $errors = $validator->validate();

    // Output $_POST data

    // Stop execution to see the data


    if (empty($errors)) {
        // Sanitize form data


        // Insert reply into the database
        echo "Form data validation successful. Inserting reply into the database...<br>";

        $author_id = $sanitizedData["user_id"];
        $topic_id = $sanitizedData["topic_id"];
        $reply_title = $sanitizedData["reply_title"];
        $reply_content  = $sanitizedData["reply_content"];


        // Assuming you have stored user ID in the session after login
        $author_id = $_SESSION['user_id'];

        $stmt = $db->prepare("INSERT INTO posts (topic_id, author_id, title, content) VALUES (:topic_id, :author_id, :title, :content)");
        $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $reply_title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $reply_content, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect user to the topic page after successfully submitting the post
        echo "Reply inserted into the database successfully. Redirecting to the topic page...<br>";
        unset($_SESSION['submitted_data']);
        header("Location: ../show_topic.php?topic_id=$topic_id");
        exit();
    } else {
        echo "Form not submitted.<br>";

        $_SESSION['errors'] = $errors;
        $_SESSION['submitted_data'] = $_POST; // Store submitted data in session

    }
}
header("Location: ../index.php");
exit();
