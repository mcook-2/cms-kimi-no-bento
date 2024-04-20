<?php
// Check authentication here
// If the user is not authenticated, redirect them to the login page
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (!isset($_POST['topic_id']) || empty($_POST['topic_id']) || !isset($_POST['title']) || empty($_POST['title']) || !isset($_POST['content']) || empty($_POST['content'])) {
        // Redirect to a page indicating that required fields are missing
        header("Location: error_page.php?error=missing_fields");
        exit();
    }

    // Retrieve form data
    $topic_id = $_POST['topic_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update the topic in the database
    $updateStmt = $db->prepare("UPDATE topics SET title = :title, topic_content = :content WHERE topic_id = :topic_id");
    $updateStmt->bindParam(':title', $title, PDO::PARAM_STR);
    $updateStmt->bindParam(':content', $content, PDO::PARAM_STR);
    $updateStmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
    $updateStmt->execute();

    // Redirect to the page displaying the updated topic
    header("Location: view_topics.adm.php");
    exit();
} else {
    // If the form is not submitted via POST method, redirect to an error page
    header("Location: error_page.php?error=invalid_request");
    exit();
}
