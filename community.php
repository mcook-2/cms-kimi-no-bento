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
                        ORDER BY c.category_id, $sort_by desc ");

$stmt->execute();
$categories_topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<div class="community-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb community-breadcrumb">
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

    <div class="community-top ">
        <h2>Community Pages</h2>
        <form action="#" method="get" class="mb-3">
            <div class="form-row">
                <?php if (isLoggedIn()) : ?>
                    <div class="form-group col-md-4">
                        <label for="sort_by">Sort By:</label>
                        <select id="sort_by" class="form-control" name="sort" style="height: auto;">
                            <option value="date_created" <?= ($sort_by === 'date_created') ? 'selected' : '' ?>>Created Date</option>
                            <option value="latest_post_created_at" <?= ($sort_by === 'latest_post_created_at') ? 'selected' : '' ?>>Latest Post Date</option>
                            <option value="title" <?= ($sort_by === 'title') ? 'selected' : '' ?>>Title</option>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="form-group col-md-4">
                    <label for="forum_jump">Select Category:</label>
                    <select id="forum_jump" class="form-control" name="category" style="height: auto;">
                        <option value="all">All Categories</option>
                        <?php foreach ($category_topics_array as $category_id => $category_data) : ?>
                            <option value="<?= $category_id ?>"><?= $category_data['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between m-1 align-self-center">
                    <button type="submit" class="btn btn-lg btn-primary mr-2">Submit</button>
                    <?php if (isLoggedIn()) : ?>
                        <a href="create_topic.php" class="btn btn-lg btn-success">Create New Topic</a>
                    <?php endif; ?>
                </div>

            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered bg-light">
            <thead class="community-thead-head">
                <tr>
                    <th scope="col">Topic & Pages</th>
                    <th scope="col">Topic Starter</th>
                    <th scope="col">Replies</th>
                    <th scope="col">Last Post</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_GET['category'])) : ?>
                    <?php $selected_category_id = $_GET['category']; ?>
                    <?php foreach ($category_topics_array as $category_id => $category_data) : ?>
                        <?php if ($selected_category_id == 'all' || $selected_category_id == $category_id) : ?>
                            <tr>
                                <td colspan="4" class="category-header">
                                    <h4><?= $category_data['category'] ?></h4>
                                </td>
                            </tr>
                            <?php foreach ($category_data['topics'] as $topic) : ?>
                                <tr>
                                    <td class="topic-td">
                                        <?php if (!empty($topic['img_url'])) : ?>
                                            <?php
                                            // Generate thumbnail image URL
                                            $originalImagePath = $topic['img_url'];
                                            $thumbnailImagePath = pathinfo($originalImagePath, PATHINFO_DIRNAME) . '/' . pathinfo($originalImagePath, PATHINFO_FILENAME) . '_thumbnail.' . pathinfo($originalImagePath, PATHINFO_EXTENSION);
                                            ?>
                                            <div class="topic-img-container">
                                                <img class="topic-img" src="<?= $thumbnailImagePath ?>" alt="topic-img">
                                            </div>
                                        <?php endif; ?>
                                        <h4><a href="show_topic.php?topic_id=<?= $topic['topic_id'] ?>"><?= (strip_tags(htmlspecialchars_decode($topic['title']))) ?></a></h4>
                                        <p><?= strlen($topic['topic_content']) > 250 ? substr(strip_tags(htmlspecialchars_decode($topic['topic_content'])), 0, 250) . '...' : strip_tags(htmlspecialchars_decode($topic['topic_content'])) ?></p>
                                    </td>
                                    <td>
                                        <span class="topic_starter_username"><?= $topic['topic_starter_username'] ?></span><br>
                                        <span class="post-date"><?= date('M d, Y', strtotime($topic['date_created'])) ?></span><br>
                                        <span class="post-time"><?= date('h:i A', strtotime($topic['date_created'])) ?></span>

                                    </td>
                                    <td>
                                        <span class="reply_count"><?= $topic['reply_count'] ?></span>
                                    </td>
                                    <td>
                                        <span class="latest-poster"><?= $topic['last_poster_username'] ?></span><br>
                                        <?php if (!empty($topic['latest_post_created_at'])) : ?>
                                            <span class="post-date"><?= date('M d, Y', strtotime($topic['latest_post_created_at'])) ?></span><br>
                                            <span class="post-time"><?= date('h:i A', strtotime($topic['latest_post_created_at'])) ?></span>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include('inc/footer.inc.php');
?>