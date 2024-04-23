<?php
include_once('../inc/config.inc.php');
include('../inc/header.inc.php');

include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');
include('../classes/profileinfo-view.classes.php');

$profileInfo = new ProfileInfo();
// Initialize $topicTitle
$crumbTitle = "";

if (isset($_GET['topic_id'])) {
    $crumb_topic_id = $_GET['topic_id'];
    // Get the topic title
    $topics = $profileInfo->getUserTopicsId($_SESSION["user_id"], $crumb_topic_id);
    // Check if topics array is not empty and get the first element
    if (!empty($topics)) {
        $crumbTitle = $topics[0]['title'];
    }
} elseif (isset($_GET['post_id'])) {
    // Check if post_id is set
    $crumb_post_id = $_GET['post_id'];
    // Get the post title
    $posts = $profileInfo->getUserPostsId($_SESSION["user_id"], $crumb_post_id);
    // Check if posts array is not empty and get the first element
    if (!empty($posts)) {
        $crumbTitle = $posts[0]['title'];
    }
}


// Check if there are any errors stored in the session
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="account.php"><?php echo $_SESSION["username"] ?></a></li>
        <li class="breadcrumb-item"><a href="view_all_posts.php">All Posts</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo isset($crumbTitle) ? $crumbTitle : 'Post'; ?></li>
    </ol>
</nav>
<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<section class="content">
    <div class="container">
        <div class="content-settings">
            <?php if (isset($_GET['topic_id'])) : ?>
                <h3 class="mb-4">Edit Topic</h3>
                <?php
                $topic_id = $_GET['topic_id'];
                $categories = $profileInfo->getCategories();
                $current_category = $profileInfo->getCurrentTopicCategory($topic_id);
                ?>
                <form action="../backend/user_content_update.php" method="post">

                    <input type="hidden" name="topic_id" value="<?php echo isset($topic_id) ? $topic_id : ''; ?>">
                    <table class="table">
                        <tr>
                            <th>Current Category</th>
                            <td><?php echo $current_category; ?></td>
                        </tr>
                        <tr>
                            <th>Select New Category</th>
                            <td>
                                <select id="category" class="form-control" name="category_name">
                                    <?php foreach ($categories as $category) : ?>
                                        <?php $selected = ($current_category == $category['name']) ? 'selected' : ''; ?>
                                        <option <?= $selected ?>><?= $category['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </td>
                        </tr>
                        <?php
                        $topics = $profileInfo->getUserTopicsId($_SESSION["user_id"], $topic_id);
                        foreach ($topics as $topic) {
                        ?>
                            <tr>
                                <th>Topic Title</th>
                                <td><textarea class="form-control" name="topic_title" id="topic_title" rows="6" placeholder=""><?php echo $topic['title']; ?></textarea></td>
                            </tr>
                            <tr>
                                <th>Topic content</th>
                                <td><textarea class="form-control" name="topic_content" id="topic_content" rows="6" placeholder=""><?php echo $topic['topic_content']; ?></textarea></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                <?php elseif (isset($_GET['post_id'])) : ?>
                    <h3 class="mb-4">Edit Post</h3>
                    <?php
                    $post_id = $_GET['post_id'];
                    $postTopic = $profileInfo->getCurrentPostTopic($post_id);
                    ?>
                    <form action="../backend/user_content_update.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo isset($post_id) ? $post_id : ''; ?>">
                        <table class="table">
                            <tr>
                                <th>Current Topic</th>
                                <td><?php echo $postTopic; ?></td>
                            </tr>
                            <?php
                            $posts = $profileInfo->getUserPostsId($_SESSION["user_id"], $post_id);
                            foreach ($posts as $post) {
                            ?>
                                <tr>
                                    <th>Post Title</th>
                                    <td><textarea class="form-control" name="post_title" id="post_title" rows="6" placeholder=""><?php echo $post['title']; ?></textarea></td>
                                </tr>
                                <tr>
                                    <th>Post content</th>
                                    <td><textarea class="form-control" name="post_content" id="post_content" rows="6" placeholder=""><?php echo $post['content']; ?></textarea></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    <?php else : ?>
                        <h3 class="mb-4">Invalid URL</h3>
                    <?php endif; ?>

                    <div class="form-group">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
                    </form>
        </div>
    </div>
</section>
<script>
    tinymce.init({
        selector: 'textarea',
        menubar: 'file edit view'
    });
</script>

<?php
include('../inc/footer.inc.php');
?>