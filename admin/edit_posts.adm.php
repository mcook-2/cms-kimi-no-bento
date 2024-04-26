<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');

// Check if the post_id is provided in the URL
if (!isset($_GET['post_id']) || empty($_GET['post_id'])) {
    // Redirect to a page indicating that the post_id is missing
    header("Location: error_page.php?error=missing_post_id");
    exit();
}

$post_id = $_GET['post_id'];
// Fetch the post from the database with the username of the poster
$stmt = $db->prepare("SELECT posts.*, users.username 
                      FROM posts 
                      LEFT JOIN users ON posts.author_id = users.user_id 
                      WHERE post_id = :post_id");
$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the post exists
if (!$post) {
    header("Location: dashboard.adm.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $updateStmt = $db->prepare("UPDATE posts SET title = :title, content = :content WHERE post_id = :post_id");
    $updateStmt->bindParam(':title', $title, PDO::PARAM_STR);
    $updateStmt->bindParam(':content', $content, PDO::PARAM_STR);
    $updateStmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $updateStmt->execute();

    header("Location: view_posts.adm.php");
    exit();
}

include('header.adm.php');
?>

<?php include('sidebar.adm.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>Edit Post</h2>
    <form method="post" action="update_posts.adm.php">
        <div class="form-group">
            <label>Username</label>
            <p><?= htmlspecialchars($post['username']) ?> </p>
            <input type="hidden" name="id" value="<?= $post_id ?>">
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="6"><?= htmlspecialchars($post['content']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</main>
</body>
<?php include('footer.adm.php'); ?>