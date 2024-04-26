<?php
include('inc/database.inc.php');
include_once('inc/config.inc.php');
include_once('inc/check_login.inc.php');
include('inc/header.inc.php');

// Fetch categories from the database
$stmt = $db->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
$contentValue = $titleValue  = '';
// Check if there are any errors stored in the session
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']); // Remove errors from session to prevent displaying them again on refresh

    // Retrieve submitted data to fill inputs
    if (isset($_SESSION['submitted_data'])) {
        $submittedData = $_SESSION['submitted_data'];
        $titleValue = isset($submittedData['topic_title']) ? htmlspecialchars($submittedData['topic_title']) : '';
        $contentValue = isset($submittedData['topic_content']) ? htmlspecialchars($submittedData['topic_content']) : '';
        unset($_SESSION['submitted_data']);
    }
}
?>

<!-- Form to create a new topic -->
<div class="container">
    <h3>Create New Topic</h3>
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="backend/create_topic_process.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="topic_title">Title:</label>
            <input type="text" class="form-control" id="topic_title" name="topic_title" value="<?= $titleValue ?>">
        </div>
        <!-- Textarea for topic content -->
        <div class="form-group">
            <label for="topic_content">Content:</label>
            <textarea class="form-control" id="topic_content" name="topic_content" rows="6"><?= $contentValue ?></textarea>
        </div>
        <div class="form-group">
            <label for="existing_category">Select Category:</label>
            <select id="category" class="form-control" name="category_name" style="height: auto;">
                <?php foreach ($categories as $category) : ?>
                    <option><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Image upload section -->
        <div class="form-group">
            <label for="topic_image">Upload Image (Optional):</label>
            <input type="file" class="form-control-file" id="topic_image" name="topic_image" onchange="previewImage(event)">
            <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px; max-height: 200px;">
        </div>
        <script>
            function previewImage(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var preview = document.getElementById('imagePreview');
                    preview.src = reader.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
        <button type="submit" class="btn btn-primary">Create Topic</button>
    </form>
</div>
<script>
    tinymce.init({
        selector: 'textarea',
        menubar: 'file edit view'

    });
</script>

<?php include('inc/footer.inc.php'); ?>