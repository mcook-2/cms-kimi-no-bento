<?php
include('inc/database.inc.php');
include_once('inc/config.inc.php');
include('inc/header.inc.php');

// Fetch categories from the database
$stmt = $db->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Form to create a new topic -->
<div class="container">
    <h3>Create New Topic</h3>
    <form action="backend/create_topic_process.php" method="post">
        <div class="form-group">
            <label for="topic_title">Title:</label>
            <input type="text" class="form-control" id="topic_title" name="topic_title">
        </div>
        <!-- Textarea for topic content -->
        <div class="form-group">
            <label for="topic_content">Content:</label>
            <textarea class="form-control" id="topic_content" name="topic_content" rows="6"></textarea>
        </div>
        <div class="form-group">

            <input class="form-check-input" type="radio" name="category_type" id="existing_category" value="existing" checked>
            <label for="existing_category">Select Existing Category:</label>
            <select id="category" class="form-control" name="existing_category_id">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <input class="form-check-input" type="radio" name="category_type" id="new_category" value="new">
            <label for="new_category">Create New Category:</label>
            <input type="text" class="form-control" id="new_category_input" name="new_category_name">
        </div>
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