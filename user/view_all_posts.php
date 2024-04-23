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
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="account.php"><?php echo $_SESSION["username"] ?></a></li>
        <li class="breadcrumb-item active" aria-current="page">All Posts</li>
    </ol>
</nav>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Posts</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Topic</th> <!-- New column for category -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $posts = $profileInfo->fetchPosts($_SESSION["user_id"]);
                        foreach ($posts as $post) :
                            $postTopic = $profileInfo->fetchCurrentPostTopic($post["post_id"]);
                        ?>
                            <tr>
                                <td><a href="user_edit.php?post_id=<?php echo $post["post_id"]; ?>"><?php echo strip_tags(htmlspecialchars_decode($post["title"])); ?></a></td>
                                <td><?php echo strip_tags(htmlspecialchars_decode($post["content"])); ?></td>
                                <td class="col-2"><?php echo strip_tags(htmlspecialchars_decode($postTopic)); ?></td> <!-- Display topic name -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h5>Topics</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Category</th> <!-- New column for category -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $topics = $profileInfo->fetchTopics($_SESSION["user_id"]);
                        foreach ($topics as $topic) :
                            // Fetch category associated with the topic
                            $category = $profileInfo->fetchCurrentCategoryTopic($topic["topic_id"]);
                        ?>
                            <tr>
                                <td><a href="user_edit.php?topic_id=<?php echo $topic["topic_id"]; ?>"><?php echo strip_tags(htmlspecialchars_decode($topic["title"])); ?></a></td>
                                <td><?php echo strip_tags(htmlspecialchars_decode($topic["topic_content"])); ?></td>
                                <td><?php echo strip_tags(htmlspecialchars_decode($category)); ?></td> <!-- Display category name -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>