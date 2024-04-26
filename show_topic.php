<?php
include('inc/database.inc.php');
include('inc/config.inc.php');
include('inc/header.inc.php');

// Check if topic_id is provided in the URL
if (isset($_GET['topic_id']) && !empty($_GET['topic_id'])) {
    $topic_id = htmlspecialchars($_GET['topic_id']);
    // might not need to do this twice

    // Fetch topic details along with the category name and topic starter's profile picture
    $stmt = $db->prepare("SELECT t.*, 
                                c.name AS category_name,
                                u.username AS topic_starter_username,
                                profiles.profiles_pfp AS topic_starter_pfp
                            FROM topics t
                            LEFT JOIN categories c ON t.category_id = c.category_id
                            LEFT JOIN users u ON t.topic_starter_id = u.user_id
                            LEFT JOIN profiles ON u.user_id = profiles.user_id
                            WHERE t.topic_id = ?");
    $stmt->execute([$topic_id]);
    $topic = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch posts related to the topic along with post authors' profile pictures
    $stmt = $db->prepare("SELECT p.*, 
                                u.username AS post_author_username,
                                profiles.profiles_pfp AS post_author_pfp
                            FROM posts p
                            LEFT JOIN users u ON p.author_id = u.user_id
                            LEFT JOIN profiles ON u.user_id = profiles.user_id
                            WHERE p.topic_id = ?
                            ORDER BY p.date_created ASC");
    $stmt->execute([$topic_id]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Redirect to a page indicating that the topic ID is missing
    header("Location: error.php");
    exit;
}


$titleValue = $contentValue = '';
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']); // Remove errors from session to prevent displaying them again on refresh

    // Retrieve submitted data to fill inputs
    if (isset($_SESSION['submitted_data'])) {
        $submittedData = $_SESSION['submitted_data'];
        $titleValue = isset($submittedData['reply_title']) ? $submittedData['reply_title'] : '';
        $contentValue = isset($submittedData['reply_content']) ? $submittedData['reply_content'] : '';
        unset($_SESSION['submitted_data']);
    }
}
?>
<div class="forum-container">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb forum-breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="community.php?category=<?= $topic['category_id'] ?>"><?= $topic['category_name'] ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= (strip_tags(htmlspecialchars_decode($topic['title']))) ?></li>
        </ol>
    </nav>
    <h2 class="forum-topic"><?= (strip_tags(htmlspecialchars_decode($topic['title']))) ?></h2>
    <div class="card">
        <div class="card-body topic-content">
            <table class=" table">
                <tbody>
                    <tr>
                        <td class="col-1  border-right border-top-0 ">
                            <?php if (!empty($topic['topic_starter_pfp'])) : ?>
                                <img src="cms-kimi-no-bento/<?= $topic['topic_starter_pfp'] ?>" alt="<?= $topic['topic_starter_username'] ?>" class="rounded-circle" width="50" height="50">
                            <?php endif; ?>
                            <p>Started by: <?= $topic['topic_starter_username'] ?></p>
                            <p>Created at: <?= $topic['date_created'] ?></p>

                        </td>
                        <td class="col-6 border-0"><?= htmlspecialchars_decode($topic['topic_content']) ?>
                            <?php if (!empty($topic['img_url'])) : ?>
                                <img class="show-topic-img" src="<?= $topic['img_url'] ?>" alt="topic-img">
                        </td>
                    <?php endif; ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="forum-post-list">
        <h2>Replys</h2>
        <?php foreach ($posts as $post) : ?>
            <div class="card">
                <div class="card-body ">
                    <table class="table">

                        <tbody>
                            <tr>
                                <td class="col-1  border-right border-top-0 ">
                                    <?php if (!empty($post['post_author_pfp'])) : ?>
                                        <img src="cms-kimi-no-bento/<?= $post['post_author_pfp'] ?>" alt="<?= $post['post_author_username'] ?>" class="rounded-circle" width="50" height="50">
                                    <?php endif; ?>
                                    <p>Author: <?= $post['post_author_username'] ?></p>
                                    <p>Posted at: <?= $post['date_created'] ?></p>
                                </td>
                                <td class="col-6 border-0">
                                    <p>Title: <?= $post['title'] ?></p>
                                    <p><?= $post['content'] ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Reply Form -->
    <?php if (isLoggedIn()) : ?>
        <div class="forum-reply-form reply-form">
            <h3>Reply to this topic</h3>
            <form method="post" action="backend/submit_post.php">
                <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                <div class="form-group">
                    <label for="reply_title">Reply Title</label>
                    <input type="text" class="form-control" id="reply_title" name="reply_title" value="<?php echo htmlspecialchars($titleValue); ?>">

                    <?php if (isset($errors['reply_title'])) : ?>
                        <div class="text-danger"><?php echo $errors['reply_title']; ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="reply_content">Your Reply</label>
                    <textarea class="form-control" id="reply_content" name="reply_content" rows="3"><?php echo htmlspecialchars($contentValue); ?></textarea>

                    <?php if (isset($errors['reply_content'])) : ?>
                        <div class="text-danger"><?php echo $errors['reply_content']; ?></div>
                    <?php endif; ?>
                </div>
                <div>
                    <img src="inc/captcha.inc.php" alt="captcha" />
                    <br />
                    <br />
                    <input type="text" name="captcha" />
                    <?php if (isset($errors['captcha'])) : ?>
                        <div class="text-danger"><?php echo $errors['captcha']; ?></div>
                    <?php endif; ?>
                </div>
                <br /><br />
                <input type="hidden" name="verify" value="1">
                <button type="submit" class="btn btn-primary">Post Reply</button>
            </form>
        </div>
    <?php else : ?>
        <div class="forum-alert alert alert-info" role="alert">
            You need to <a href="user/login.php">log in</a> or <a href="user/register.php">register</a> to post a reply.
        </div>
    <?php endif; ?>
</div>

<?php include('inc/footer.inc.php'); ?>