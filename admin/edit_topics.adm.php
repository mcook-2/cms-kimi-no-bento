<?php
// Check authentication here
// If the user is not authenticated, redirect them to the login page
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');

// Check if the topic_id is provided in the URL
if (!isset($_GET['topic_id']) || empty($_GET['topic_id'])) {
    // Redirect to a page indicating that the topic_id is missing
    header("Location: error_page.php?error=missing_topic_id");
    exit();
}

$topic_id = $_GET['topic_id'];

// Fetch the topic from the database
$stmt = $db->prepare("SELECT * FROM topics WHERE topic_id = :topic_id");
$stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
$stmt->execute();
$topic = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the topic exists
if (!$topic) {
    // Redirect to a page indicating that the topic does not exist
    header("Location: error_page.php?error=topic_not_found");
    exit();
}

// Handle form submission for updating the topic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    // You may want to add more validation and sanitization here

    // Update the topic in the database
    $updateStmt = $db->prepare("UPDATE topics SET title = :title, topic_content = :content WHERE topic_id = :topic_id");
    $updateStmt->bindParam(':title', $title, PDO::PARAM_STR);
    $updateStmt->bindParam(':content', $content, PDO::PARAM_STR);
    $updateStmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
    $updateStmt->execute();

    // Redirect to the page displaying the updated topic
    header("Location: view_topics.adm.php");
    exit();
}

// Include header
include('header.adm.php');
?>

<?php include('sidebar.adm.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>Edit Topic</h2>
    <form method="post" action="update_topics.adm.php">
        <input type="hidden" name="topic_id" value="<?= htmlspecialchars($topic['topic_id']) ?>">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($topic['title']) ?>">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="6"><?= htmlspecialchars($topic['topic_content']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Topic</button>
    </form>
</main>


<?php include('footer.adm.php'); ?>
</body>
<script>
    tinymce.init({
        selector: '#content',
        menubar: 'file edit view'
    });
</script>


</html>