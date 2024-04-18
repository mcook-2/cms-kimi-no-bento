<?php
include('inc/database.inc.php');
include('inc/config.inc.php');
include('inc/header.inc.php');

// Check if topic_id is provided in the URL
if (isset($_GET['topic_id']) && !empty($_GET['topic_id'])) {
    $topic_id = htmlspecialchars($_GET['topic_id']);
    // might not need to do this twice

    // Fetch topic details along with the category name
    $stmt = $db->prepare("SELECT t.*, 
                                c.name AS category_name,
                                u.username AS topic_starter_username
                            FROM topics t
                            LEFT JOIN categories c ON t.category_id = c.category_id
                            LEFT JOIN users u ON t.topic_starter_id = u.user_id
                            WHERE t.topic_id = ?");
    $stmt->execute([$topic_id]);
    $topic = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch posts related to the topic
    $stmt = $db->prepare("SELECT p.*, 
                                u.username AS post_author_username
                            FROM posts p
                            LEFT JOIN users u ON p.author_id = u.user_id
                            WHERE p.topic_id = ?
                            ORDER BY p.date_created ASC");
    $stmt->execute([$topic_id]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Redirect to a page indicating that the topic ID is missing
    header("Location: error.php");
    exit;
}
?>

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="community.php?category=<?= $topic['category_id'] ?>"><?= $topic['category_name'] ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $topic['title'] ?></li>
        </ol>
    </nav>
    <h1><?= $topic['category_name'] ?> </h1>
    <h2><?= $topic['title'] ?></h2>
    <div class="card">
        <div class="card-body">
            <div class="topic-info">
                <?= htmlspecialchars_decode($topic['topic_content']) ?>
                <p>Started by: <?= $topic['topic_starter_username'] ?></p>
                <p>Created at: <?= $topic['date_created'] ?></p>
            </div>
        </div>
    </div>

    <div class="post-list">
        <h3>Posts</h3>
        <?php foreach ($posts as $post) : ?>
            <div class="card">
                <div class="card-body">
                    <div class="post-info">
                        <p>Author: <?= $post['post_author_username'] ?></p>
                        <p>Posted at: <?= $post['date_created'] ?></p>
                        <p>Title: <?= $post['title'] ?></p> <!-- Display the post title -->
                    </div>
                    <div class="post-content">
                        <?= $post['content'] ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Reply Form -->
    <?php if (isLoggedIn()) : ?>
        <div class="reply-form">
            <h3>Reply to this topic</h3>
            <form method="post" action="backend/submit_post.php">
                <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                <div class="form-group">
                    <label for="reply_title">Reply Title</label> <!-- Add a label for the title input -->
                    <input type="text" class="form-control" id="reply_title" name="reply_title"> <!-- Add a text input for the title -->
                </div>
                <div class="form-group">
                    <label for="reply_content">Your Reply</label>
                    <textarea class="form-control" id="reply_content" name="reply_content" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Reply</button>
            </form>
        </div>
    <?php else : ?>
        <div class="alert alert-info" role="alert">
            You need to <a href="user/login.php">log in</a> or <a href="user/register.php">register</a> to post a reply.
        </div>
    <?php endif; ?>

    <?php
    include('inc/footer.inc.php');
    ?>