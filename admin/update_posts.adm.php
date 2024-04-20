<?php
// Check authentication here
// If the user is not authenticated, redirect them to the login page
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (!isset($_POST['id']) || empty($_POST['id']) || !isset($_POST['title']) || empty($_POST['title']) || !isset($_POST['content']) || empty($_POST['content'])) {
        // Redirect to a page indicating that required fields are missing
        header("Location: error_page.php?error=missing_fields");
        exit();
    }

    // Retrieve form data
    $post_id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update the post in the database
    $updateStmt = $db->prepare("UPDATE posts SET title = :title, content = :content WHERE post_id = :post_id");
    $updateStmt->bindParam(':title', $title, PDO::PARAM_STR);
    $updateStmt->bindParam(':content', $content, PDO::PARAM_STR);
    $updateStmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $updateStmt->execute();

    // Redirect to the page displaying the updated post
    header("Location: view_posts.adm.php");
    exit();
} else {
    // If the form is not submitted via POST method, redirect to an error page
    header("Location: error_page.php?error=invalid_request");
    exit();
}
