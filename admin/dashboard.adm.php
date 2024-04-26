<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');

// Fetch latest posts
$stmt_posts = $db->query("SELECT post_id, title FROM posts ORDER BY date_created DESC LIMIT 10");
$latest_posts = $stmt_posts->fetchAll(PDO::FETCH_ASSOC);

// Fetch latest topics
$stmt_topics = $db->query("SELECT topic_id, title FROM topics ORDER BY date_created DESC LIMIT 10");
$latest_topics = $stmt_topics->fetchAll(PDO::FETCH_ASSOC);

// Fetch latest categories
$stmt_categories = $db->query("SELECT category_id, name FROM categories ORDER BY date_created DESC LIMIT 10");
$latest_categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

// Fetch latest users
$stmt_users = $db->query("SELECT user_id, username FROM users ORDER BY date_created DESC LIMIT 10");
$latest_users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// Fetch statistics
$stmt_statistics = $db->query("SELECT COUNT(*) AS total_posts FROM posts");
$total_posts = $stmt_statistics->fetch(PDO::FETCH_ASSOC)['total_posts'];

$stmt_statistics = $db->query("SELECT COUNT(*) AS total_topics FROM topics");
$total_topics = $stmt_statistics->fetch(PDO::FETCH_ASSOC)['total_topics'];

$stmt_statistics = $db->query("SELECT COUNT(*) AS total_users FROM users");
$total_users = $stmt_statistics->fetch(PDO::FETCH_ASSOC)['total_users'];

$stmt_statistics = $db->query("SELECT COUNT(*) AS total_categories FROM categories");
$total_categories = $stmt_statistics->fetch(PDO::FETCH_ASSOC)['total_categories'];

include('header.adm.php');
?>

<?php include('sidebar.adm.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin Dashboard</h1>
    </div>
    <!-- Recent Activity -->
    <div class="row mb-4">
        <div class="col-md-3">
            <h2>Recent Posts</h2>
            <ul>
                <?php foreach ($latest_posts as $post) : ?>
                    <li><a href="view_posts.adm.php?id=<?= $post['post_id'] ?>"><?= $post['title'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-3">
            <h2>Recent Topics</h2>
            <ul>
                <?php foreach ($latest_topics as $topic) : ?>
                    <li><a href="view_topics.adm.php?id=<?= $topic['topic_id'] ?>"><?= $topic['title'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-3">
            <h2>Recent Categories</h2>
            <ul>
                <?php foreach ($latest_categories as $category) : ?>
                    <li><a href="view_categories.adm.php?id=<?= $category['category_id'] ?>"><?= $category['name'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-3">
            <h2>Recent Users</h2>
            <ul>
                <?php foreach ($latest_users as $user) : ?>
                    <li><a href="view_users.adm.php?id=<?= $user['user_id'] ?>"><?= $user['username'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!-- Statistics -->
    <h2>Statistics</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Posts</h5>
                    <p class="card-text"><?= $total_posts ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Topics</h5>
                    <p class="card-text"><?= $total_topics ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                    <p class="card-text"><?= $total_categories ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?= $total_users ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="text-left mb-4">
                <h2>Quick Actions</h2>
                <a href="add_user.adm.php" class="btn btn-primary btn-lg">Add User</a>
                <a href="create_category.adm.php" class="btn btn-lg btn-success">Create new Category</a>
            </div>
        </div>
    </div>
    <!-- Important Notifications or Alerts -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Important Notifications</h2>
            <!-- Highlight any critical information or updates -->
            <div class="alert alert-warning" role="alert">
                There are pending tasks that require your attention.
            </div>
        </div>
    </div>
</main>
</body>
<?php include('footer.adm.php'); ?>