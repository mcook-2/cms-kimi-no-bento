<?php
include('../Backend/database.php');
include('../Backend/config.php');
include('../Backend/header.php');

$thread_id = $_GET['thread_id'];

try {
    // Query to fetch the thread title for the specified thread ID
    $thread_title_query = "SELECT thread_title FROM threads WHERE thread_id = :thread_id";
    $thread_title_statement = $db->prepare($thread_title_query);
    $thread_title_statement->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
    $thread_title_statement->execute();
    $thread = $thread_title_statement->fetch(PDO::FETCH_ASSOC);

    // Check if the thread title is retrieved
    if ($thread) {
        $thread_title = $thread['thread_title'];

        // Query to fetch posts for the specified thread
        $post_query = "SELECT p.post_id, p.thread_id, p.user_id, p.date_created, p.content, 
                              u.username
                       FROM posts p
                       LEFT JOIN users u ON p.user_id = u.user_id
                       WHERE p.thread_id = :thread_id
                       ORDER BY p.date_created";

        $post_statement = $db->prepare($post_query);
        $post_statement->bindParam(':thread_id', $thread_id, PDO::PARAM_INT);
        $post_statement->execute();
        $posts = $post_statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Handle case where thread title is not found
        $thread_title = "Thread Not Found";
        $posts = array(); // Empty array
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<div id="pagetitle">
    <h1 id="forum-title"><?php echo htmlspecialchars($thread_title); ?></h1>
</div>

<div class="post-wrapper">
    <?php if (empty($posts)) : ?>
        <div class="post">
            <div class="post-info">
            </div>
            <div class="post-content">
                <p>No posts yet. Be the first to post!</p>
            </div>
        </div>

    <?php else : ?>
        <?php foreach ($posts as $post) : ?>
            <div class="post">
                <div class="post-info">
                    <p>Posted by <strong><?php echo $post['username']; ?></strong> on <?php echo $post['date_created']; ?></p>
                </div>
                <div class="post-content">
                    <p><?php echo $post['content']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
include('../Backend/footer.php');
?>