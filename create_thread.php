<?php
// Include necessary files
include('inc/database.inc.php');

include_once('inc/config.inc.php');

include('inc/header.inc.php');

// Check if user is logged in
if (!isLoggedIn()) {
    // Redirect to login page if not logged in
    header("Location: user/login.php");
    exit();
}

// Check if a category ID is provided
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch category name for display
    $category_name_query = "SELECT cat_name FROM categories WHERE cat_id = :category_id";
    $category_name_statement = $db->prepare($category_name_query);
    $category_name_statement->bindParam(':category_id', $category_id);
    $category_name_statement->execute();
    $category_name_result = $category_name_statement->fetch(PDO::FETCH_ASSOC);
} else {
    // If category ID is not provided, show an error message
    echo "<p>Error: Category ID not specified.</p>";
    include('inc/footer.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $thread_title = $_POST['thread_title'];
    $thread_description = $_POST['thread_description'];
    // Validate form data (you can add more validation if needed)

    try {
        // Insert new thread into the database
        $insert_thread_query = "INSERT INTO threads (cat_id, thread_title, thread_description) VALUES (:category_id, :thread_title, :thread_description)";
        $insert_thread_statement = $db->prepare($insert_thread_query);
        $insert_thread_statement->bindParam(':category_id', $category_id);
        $insert_thread_statement->bindParam(':thread_title', $thread_title);
        $insert_thread_statement->bindParam(':thread_description', $thread_description);
        $insert_thread_statement->execute();

        // Redirect to the category page after thread creation
        header("Location: show_category.php?category_id=$category_id");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<h1>Create New Thread in <?php echo htmlspecialchars($category_name_result['cat_name']); ?></h1>

<form method="post" action="submit_thread.php">
    <label for="thread_title">Thread Title:</label><br>
    <input type="text" id="thread_title" name="thread_title" required><br>

    <label for="thread_description">Thread Description:</label><br>
    <textarea id="thread_description" name="thread_description" required></textarea><br>

    <label for="subcategory">Subcategory:</label><br>
    <select id="subcategory" name="subcategory">
        <!-- Option to select from existing subcategories -->
        <?php
        // Fetch most recent subcategories for the category
        $subcategory_query = "SELECT subcat_id, subcat_name FROM subcategories WHERE cat_id = :category_id ORDER BY date_created DESC LIMIT 10";
        $subcategory_statement = $db->prepare($subcategory_query);
        $subcategory_statement->bindParam(':category_id', $category_id);
        $subcategory_statement->execute();
        $subcategories = $subcategory_statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($subcategories as $subcategory) {
            echo "<option value=\"{$subcategory['subcat_id']}\">{$subcategory['subcat_name']}</option>";
        }
        ?>
    </select><br>

    <!-- Input field to add a new subcategory -->
    <label for="new_subcategory">New Subcategory:</label><br>
    <input type="text" id="new_subcategory" name="new_subcategory"><br>

    <!-- Hidden input field to store the category ID -->
    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">

    <input type="submit" value="Submit">
</form>


<?php
include('inc/footer.inc.php');
?>