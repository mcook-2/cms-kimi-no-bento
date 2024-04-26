<?php
include('../inc/config.inc.php');
include('../inc/database.inc.php');
include('../classes/form_validator.classes.php');
include('../classes/form_sanitizer.classes.php');

// Check if the user is logged in
if (!isLoggedIn()) {
    header("Location: user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $submittedCaptcha = $_POST['captcha'];

    // Retrieve CAPTCHA value stored in the session
    $captchaValue = $_SESSION['captcha'];

    $sanitizedData = FormSanitizer::sanitize($_POST);
    $topic_id = $sanitizedData["topic_id"];

    $validator = new FormValidator($sanitizedData);

    // Validate form data
    $errors = $validator->validate();

    // Compare submitted CAPTCHA value with the one stored in the session
    if ($submittedCaptcha !== $captchaValue) {
        // CAPTCHA validation failed, redirect back to the form page with an error message
        $_SESSION['errors']['captcha'] = "Invalid CAPTCHA code. Please try again.";
        $errors = array_merge($errors, $_SESSION['errors']);

        $flag = false;
    }

    if ($submittedCaptcha === $captchaValue) {

        $flag = true;
    }

    if (empty($errors) && $flag == true) {

        // Insert reply into the database

        $author_id = $sanitizedData["user_id"];
        $topic_id = $sanitizedData["topic_id"];
        $reply_title = $sanitizedData["reply_title"];
        $reply_content  = $sanitizedData["reply_content"];

        $author_id = $_SESSION['user_id'];

        $stmt = $db->prepare("INSERT INTO posts (topic_id, author_id, title, content) VALUES (:topic_id, :author_id, :title, :content)");
        $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $reply_title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $reply_content, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect user to the topic page after successfully submitting the post
        unset($_SESSION['submitted_data']);
        header("Location: ../show_topic.php?topic_id=$topic_id");
        exit();
    } else {
        // Redirect user & send errors back to topic forum 
        $_POST['topic_id'];
        $_SESSION['errors'] = $errors;
        $_SESSION['submitted_data'] = $_POST;
        header("Location: ../show_topic.php?topic_id=$topic_id");
        exit();
    }
}
header("Location: ../index.php");
exit();
