<?php
include('../inc/database.inc.php');
include('header.adm.php');
include('sidebar.adm.php');

// Check if category_id is provided in the URL
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Query to fetch category data from the database
    $stmt = $db->prepare("SELECT * FROM categories WHERE category_id = :category_id");
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if category exists
    if ($category) {
        // Display category edit form
?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h2>Edit Category</h2>
            <form action="update_categories.adm.php" method="POST">
                <div class="form-group">
                    <label for="category_id">Category ID:</label>
                    <input type="text" name="category_id" id="category_id" class="form-control" value="<?= $category['category_id'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name">Category Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= $category['name'] ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </form>
        </main>
        </body>
<?php
    } else {
        echo "Category not found.";
    }
} else {
    echo "Category ID not provided.";
}

include('footer.adm.php');
?>