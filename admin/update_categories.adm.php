<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');
include('header.adm.php');
include('sidebar.adm.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if category_id is provided
    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];

        // Update category
        if (!empty($_POST['name'])) {
            // Update category name
            $name = $_POST['name'];
            $stmt = $db->prepare("UPDATE categories SET name = :name WHERE category_id = :category_id");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                // Redirect back to view_categories.adm.php with success message
                header("Location: view_categories.adm.php?success=true");
                exit();
            } else {
                echo "Error updating category.";
                header("Location: edit_categories.adm.php?category_id=$category_id&error=update_fail");
                exit();
            }
        } else {
            header("Location: edit_categories.adm.php?category_id=$category_id&error=invalid_name");
            exit();
        }
    } else {
        header("Location: dashboard.adm.php?error=invalid_id");
        exit();
    }
} else {
    header("Location: dashboard.adm.php?error=invalid_request");
    exit();
}
header("Location: dashboard.adm.php?error=invalid_post");
exit();
// Include footer
include('footer.adm.php');
