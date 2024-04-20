<?php
include_once '../inc/config.inc.php';
include '../inc/header.inc.php';
include '../inc/check_login.inc.php';
include '../classes/database.classes.php';
include '../classes/profileinfo.classes.php';
include '../classes/profileinfo-contr.classes.php';
include '../classes/profileinfo-view.classes.php';

$profileInfo = new ProfileInfoView();
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Posts</h5>
        </div>
        <div class="card-body dropdown">
            <div class="col-sm-10">
                <?php
                // Call fetchPosts function to get the last 5 most recent posts
                $posts = $profileInfo->fetchPosts($_SESSION["user_id"]);
                foreach ($posts as $post) :
                ?>

                    <h2><a class="" href="user_edit.php?post_id=<?php echo $post["post_id"]; ?>"><?php echo strip_tags(htmlspecialchars_decode($post["title"])); ?></a></h2>
                    <p><?php echo strip_tags(htmlspecialchars_decode($post["content"])); ?></p>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>topics</h5>
        </div>
        <div class="card-body">
            <div class="col-sm-10">
                <?php
                // Call fetchTopics function to get the last 5 most recent topics
                $topics = $profileInfo->fetchTopics($_SESSION["user_id"]);
                foreach ($topics as $topic) :
                ?>
                    <h2><a href="user_edit.php?topic_id=<?php echo $topic["topic_id"]; ?>"><?php echo strip_tags(htmlspecialchars_decode($topic["title"])); ?></a></h2>
                    <p><?php echo strip_tags(htmlspecialchars_decode($topic["topic_content"])); ?></p>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Category</h5>
        </div>
        <div class="card-body">
            <div class="col-sm-10">


                <?php
                // Call fetchTopics function to get the last 5 most recent topics
                $categories = $profileInfo->fetchCategories($_SESSION["user_id"]);
                foreach ($categories as $category) :
                ?>
                    <h2><a href="user_edit.php?category_id=<?php echo $category["category_id"]; ?>"><?php echo $category["name"]; ?></a></h2>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>