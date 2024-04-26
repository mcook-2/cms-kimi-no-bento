<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');
include('header.adm.php');
include('sidebar.adm.php');

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $stmt = $db->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Category created successfully
            header("Location: view_categories.adm.php?success=true");
            exit();
        } else {
            // Error occurred while creating category
            $errors[] = "Error: Unable to create category.";
        }
    } else {
        // Name field is empty
        $errors[] = "Please enter a category name.";
    }
}

?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>Create new Category</h2>
    <?php foreach ($errors as $error) : ?>
        <div class="alert alert-warning" role="alert"><?= $error ?></div>
    <?php endforeach; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="">
        </div>
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</main>
</body>
<?php include('footer.adm.php'); ?>