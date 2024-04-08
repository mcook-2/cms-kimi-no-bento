<?php
include('inc/database.inc.php');

include_once('inc/config.inc.php');

include('inc/header.inc.php');

// Fetch categories
$stmt = $db->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if a category is selected
if (isset($_GET['category']) && !empty($_GET['category'])) {

    $selected_category = $_GET['category'];

    $stmt = $db->prepare("SELECT t.*, 
                            u.username AS topic_starter_username, 
                            MAX(p.created_at) AS latest_post_created_at,
                            lp.username AS last_poster_username,
                            COUNT(p.post_id) AS reply_count
                        FROM topics t
                        LEFT JOIN users u ON t.topic_starter_id = u.user_id
                        LEFT JOIN (
                            SELECT topic_id, MAX(created_at) AS latest_post_created_at
                            FROM posts
                            GROUP BY topic_id
                        ) latest_post ON t.topic_id = latest_post.topic_id
                        LEFT JOIN posts p ON t.topic_id = p.topic_id AND p.created_at = latest_post.latest_post_created_at
                        LEFT JOIN users lp ON p.author_id = lp.user_id
                        WHERE t.category_id = ?
                        GROUP BY t.topic_id
                        ORDER BY t.created_at DESC");
    $stmt->execute([$selected_category]);
    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<div class="container">
    <div class="card">
        <div class="card-top">
            <h2>Topics</h2>
            <form action="" method="get">
                <div class="form-group">
                    <label for="forum_jump">Select Category:</label>
                    <select id="forum_jump" class="form-control" name="category">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <div class="row">
                <div class="col-8">
                    <strong>Topic & Pages</strong>
                </div>
                <div class="col">
                    <strong>Topic Starter</strong>
                </div>
                <div class="col">
                    <strong>Replies</strong>
                </div>
                <div class="col">
                    <strong>Last Post</strong>
                </div>
            </div>
        </div>
        <?php if (isset($topics)) : ?>
            <div class="card-body">
                <?php foreach ($topics as $topic) : ?>
                    <div class="row">
                        <div class="col-8">
                            <a href="show_topic.php?topic_id=<?= $topic['topic_id'] ?>"><?= $topic['title'] ?></a>
                        </div>

                        <div class="col">
                            <span class="topic_starter_username"><?= $topic['topic_starter_username'] ?></span>
                            <span class="post-date"><?= $topic['created_at'] ?></span>
                        </div>

                        <div class="col">
                            <span class="reply_count"><?= $topic['reply_count'] ?></span>
                        </div>
                        <div class="col">
                            <span class="latest-poster">
                                <?php if ($topic['latest_post_created_at'] !== null) : ?>
                                    <?= $topic['last_poster_username'] ?>
                                    <span class="post-date"><?= $topic['latest_post_created_at'] ?></span>
                                <?php else : ?>
                                    <?= $topic['topic_starter_username'] ?>
                                    <span class="post-date"><?= $topic['created_at'] ?></span>
                                <?php endif; ?>
                            </span>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>

<?php
include('inc/footer.inc.php');
?>