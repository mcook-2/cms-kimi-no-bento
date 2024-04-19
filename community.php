<?php
include('inc/database.inc.php');
include_once('inc/config.inc.php');
include('inc/header.inc.php');

if (isLoggedIn()) {
    // Default sorting option
    $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 't.date_created';

    // Define allowed sorting options
    $allowed_sort_fields = ['t.title', 't.date_created', 'latest_post_created_at'];
    if (!in_array($sort_by, $allowed_sort_fields)) {
        $sort_by = 't.created_at'; // Default to created date if invalid sort field
    }
}
$sort_by = 't.date_created'; // Default to created date if invalid sort field
$stmt = $db->prepare("SELECT c.*, 
                            t.*, 
                            u.username AS topic_starter_username, 
                            MAX(p.date_created) AS latest_post_created_at,
                            lp.username AS last_poster_username,
                            COUNT(p.post_id) AS reply_count
                        FROM categories c
                        LEFT JOIN topics t ON c.category_id = t.category_id
                        LEFT JOIN users u ON t.topic_starter_id = u.user_id
                        LEFT JOIN (
                            SELECT topic_id, MAX(date_created) AS latest_post_created_at
                            FROM posts
                            GROUP BY topic_id
                        ) latest_post ON t.topic_id = latest_post.topic_id
                        LEFT JOIN posts p ON t.topic_id = p.topic_id
                        LEFT JOIN users lp ON p.author_id = lp.user_id
                        GROUP BY c.category_id, t.topic_id
                        ORDER BY c.category_id, $sort_by DESC ");

$stmt->execute();
$categories_topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build an associative array to organize topics by category
$category_topics_array = [];
foreach ($categories_topics as $row) {
    $category_id = $row['category_id'];
    if (!isset($category_topics_array[$category_id])) {
        $category_topics_array[$category_id] = [
            'category' => $row['name'],
            'topics' => [],
            'topic_content' => htmlspecialchars($row['topic_content'])

        ];
    }
    $category_topics_array[$category_id]['topics'][] = $row;
}
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <?php if (isset($_GET['category']) && $_GET['category'] !== 'all' && isset($category_topics_array[$_GET['category']])) : ?>
                <?php $selected_category_id = $_GET['category']; ?>
                <?php $selected_category_name = $category_topics_array[$selected_category_id]['category']; ?>
                <li class="breadcrumb-item active" aria-current="page"><?= $selected_category_name ?></li>
            <?php else : ?>
                <li class="breadcrumb-item active" aria-current="page">All Categories</li>
            <?php endif; ?>
        </ol>
    </nav>

    <div class="card">
        <div class="card-top">
            <h2>Community Pages</h2>
            <form action="" method="get">
                <div class="form-group">
                    <?php if (isLoggedIn()) : ?>
                        <label for="sort_by">Sort By:</label>
                        <select id="sort_by" class="form-control" name="sort">
                            <option value="date_created" <?= ($sort_by === 'date_created') ? 'selected' : '' ?>>Created Date</option>
                            <option value="latest_post_created_at" <?= ($sort_by === 'latest_post_created_at') ? 'selected' : '' ?>>Latest Post Date</option>
                            <option value="title" <?= ($sort_by === 'title') ? 'selected' : '' ?>>Title</option>
                        </select>
                    <?php endif; ?>
                    <label for="forum_jump">Select Category:</label>
                    <select id="forum_jump" class="form-control" name="category">
                        <option value="all">All Categories</option>
                        <?php foreach ($category_topics_array as $category_id => $category_data) : ?>
                            <option value="<?= $category_id ?>"><?= $category_data['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <?php if (isLoggedIn()) : ?>
                    <a href="create_topic.php" class="btn btn-success">Create New Topic</a>
                <?php endif; ?>
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
        <div class="card-body">
            <?php if (isset($_GET['category'])) : ?>
                <?php $selected_category_id = $_GET['category']; ?>
                <?php foreach ($category_topics_array as $category_id => $category_data) : ?>
                    <?php if ($selected_category_id == 'all' || $selected_category_id == $category_id) : ?>
                        <h3><?= $category_data['category'] ?></h3>
                        <?php foreach ($category_data['topics'] as $topic) : ?>
                            <div class="row">
                                <div class="col-8">
                                    <h4><a href="show_topic.php?topic_id=<?= $topic['topic_id'] ?>"><?= $topic['title'] ?></a></h4>
                                    <p><?= strlen($topic['topic_content']) > 250 ? substr(strip_tags(htmlspecialchars_decode($topic['topic_content'])), 0, 250) . '...' : strip_tags(htmlspecialchars_decode($topic['topic_content'])) ?></p>

                                </div>
                                <div class="col">
                                    <span class="topic_starter_username"><?= $topic['topic_starter_username'] ?></span>
                                    <span class="post-date"><?= $topic['date_created'] ?></span>
                                </div>
                                <div class="col">
                                    <span class="reply_count"><?= $topic['reply_count'] ?></span>
                                </div>
                                <div class="col">
                                    <span class="latest-poster">
                                        <?= $topic['last_poster_username'] ?>
                                        <span class="post-date"><?= $topic['latest_post_created_at'] ?></span>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php
include('inc/footer.inc.php');
?>