<?php
// Include necessary files and initialize database connection
include('../inc/database.inc.php');
include('header.adm.php');
include('sidebar.adm.php');
var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if category_id is provided
    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];

        // Check if the form is for updating or deleting
        if (isset($_POST['update'])) {
            // Update category
            if (isset($_POST['name'])) {
                $name = htmlspecialchars($_POST['name']);
                $stmt = $db->prepare("UPDATE categories SET name = :name WHERE category_id = :category_id");
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    // Redirect back to view_categories.adm.php with success message
                    header("Location: view_categories.adm.php?success=true");
                    exit();
                } else {
                    echo "Error updating category.";
                }
            } else {
                echo "Category name not provided.";
            }
        } elseif (isset($_POST['delete'])) {
            // Delete category
            $stmt = $db->prepare("DELETE FROM categories WHERE category_id = :category_id");
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                // Redirect back to view_categories.adm.php with success message
                header("Location: view_categories.adm.php?success=true");
                exit();
            } else {
                echo "Error deleting category.";
            }
        } else {
            echo " Action not specified.";
        }
    } else {
        echo "Category ID not provided.";
    }
} else {
    echo "Invalid request.";
}

// Include footer
include('footer.adm.php');
