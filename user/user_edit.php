<?php
include_once('../inc/config.inc.php');
include('../inc/header.inc.php');

include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');
include('../classes/profileinfo-view.classes.php');

$profileInfo = new ProfileInfo();
?>

<section class="content">
    <div class="container">
        <div class="content-settings">
            <!-- Display form or content for editing topics -->
            <?php if (isset($_GET['topic_id'])) : ?>
                <h3 class="mb-4">Edit Topic</h3>
                <?php
                $topic_id = $_GET['topic_id'];
                $topics = $profileInfo->getUserTopicsId($_SESSION["user_id"], $topic_id);
                foreach ($topics as $topic) {
                ?>
                    <div class="form-group">
                        <label for="about">Topic Title</label>
                        <textarea class="form-control" name="about" id="about" rows="6" placeholder=""><?php echo $topic['title']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="about">Topic content</label>
                        <textarea class="form-control" name="about" id="about" rows="6" placeholder=""><?php echo $topic['topic_content']; ?></textarea>
                    </div>
                <?php
                }
                ?>
                <!-- Display form or content for editing posts -->
            <?php elseif (isset($_GET['post_id'])) : ?>
                <h3 class="mb-4">Edit Post</h3>
                <?php
                $post_id = $_GET['post_id'];
                $posts = $profileInfo->getUserPostsId($_SESSION["user_id"], $post_id);
                foreach ($posts as $post) {
                ?>
                    <div class="form-group">
                        <label for="about">Post Title</label>
                        <textarea class="form-control" name="about" id="about" rows="6" placeholder=""><?php echo $post['title']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="about">Post content</label>
                        <textarea class="form-control" name="about" id="about" rows="6" placeholder=""><?php echo $post['content']; ?></textarea>
                    </div>
                <?php
                }
                ?>

                <!-- Display form or content for editing categories -->
            <?php elseif (isset($_GET['category_id'])) : ?>
                <h3 class="mb-4">Edit Category</h3>
                <?php
                $category_id = $_GET['category_id'];
                $categories = $profileInfo->getUserCategoriesId($_SESSION["user_id"], $category_id);
                foreach ($categories as $category) {
                ?>
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $category['name']; ?>">
                    </div>
                <?php
                }
                ?>
            <?php else : ?>
                <h3 class="mb-4">Invalid URL</h3>
            <?php endif; ?>
            <form action="#" method="post">
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