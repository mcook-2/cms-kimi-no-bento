<?php
include_once('../inc/config.inc.php');

include('../inc/header.inc.php');
include('../inc/check_login.inc.php');

include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');
include('../classes/profileinfo-view.classes.php');


$profileInfo = new ProfileInfoView();


// need to display html chars
?>




<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="profile-info-img"><img src="https://via.placeholder.com/150" class="card-img-top" alt="Profile Picture">
                    <a href="profile_settings.php" class="btn btn-primary">Profile Settings</a>
                </div>
                <div class="card-body">
                    <h4 class="card-title"> <?php echo $_SESSION["username"]; ?>
                    </h4>
                    <h6>BIO</h6>
                    <p class="card-text">
                        <?php $profileInfo->fetchAbout($_SESSION["user_id"]); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <p>
                        <?php $profileInfo->fetchTitle($_SESSION["user_id"]); ?>
                    </p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="username"></label>
                        <p class="form-control-static">
                            <?php $profileInfo->fetchText($_SESSION["user_id"]); ?>
                        </p>
                    </div>
                </div>
                <!-- Center Section -->
                <div class="card">
                    <div class="card-header">
                        <h5>Last 5 Most Recent Posts</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        // Call the fetchPosts function to get the last 5 most recent posts
                        $profileInfo->fetchPosts($_SESSION["user_id"]);

                        // Display the last 5 most recent posts

                        ?>
                    </div>
                </div>
                <!-- End Center Section -->
                <div class="mt-3">
                    <a href="view_all_posts.php" class="btn btn-secondary">View All Posts</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include('../inc/footer.inc.php');
?>