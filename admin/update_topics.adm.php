<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');
include('../classes/form_validator.classes.php');
include('../classes/form_sanitizer.classes.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (
        !isset($_POST['topic_id']) || empty($_POST['topic_id']) ||
        !isset($_POST['title']) || empty($_POST['title']) ||
        !isset($_POST['content']) || empty($_POST['content']) ||
        !isset($_POST['category_name']) || empty($_POST['category_name'])
    ) {
        // Redirect to a page indicating that required fields are missing
        header("Location: view_topics.adm.php?error=missing_fields");
        exit();
    }

    // Sanitize form data
    $sanitizedData = FormSanitizer::sanitize($_POST);

    // Retrieve form data
    $topic_id = $sanitizedData['topic_id'];
    $title = $sanitizedData['title'];
    $content = $sanitizedData['content'];
    $category_name = $sanitizedData['category_name'];

    // Retrieve the category ID from the database using its name
    $categoryStmt = $db->prepare("SELECT category_id FROM categories WHERE name = :category_name");
    $categoryStmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
    $categoryStmt->execute();
    $categoryResult = $categoryStmt->fetch(PDO::FETCH_ASSOC);

    // Check if category exists
    if ($categoryResult) {
        $category_id = $categoryResult['category_id'];

        // Update the topic in the database
        $updateStmt = $db->prepare("UPDATE topics SET title = :title, topic_content = :content, category_id = :category_id WHERE topic_id = :topic_id");
        $updateStmt->bindParam(':title', $title, PDO::PARAM_STR);
        $updateStmt->bindParam(':content', $content, PDO::PARAM_STR);
        $updateStmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $updateStmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
        $updateStmt->execute();

        // Redirect to the page displaying the updated topic
        header("Location: view_topics.adm.php?update=true");
        exit();
    } else {
        // Redirect to a page indicating that the specified category does not exist
        header("Location: view_topics.adm.php?error=invalid_category");
        exit();
    }
} else {
    // If the form is not submitted via POST method, redirect to an error page
    header("Location: dashboard.adm.php?error=invalid_request");
    exit();
}
