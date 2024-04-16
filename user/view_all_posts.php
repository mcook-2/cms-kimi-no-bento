<?php

include_once('../inc/config.inc.php');

include('../inc/header.inc.php');
include('../inc/check_login.inc.php');

include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');
include('../classes/profileinfo-view.classes.php');

$profileInfo = new ProfileInfoView();

?>



<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Posts</h5>
        </div>
        <div class="card-body">
            <div class="col-sm-10">
                <?php
                // Call the fetchPosts function to get the last 5 most recent posts
                $profileInfo->fetchPosts($_SESSION["user_id"]);

                // Display the last 5 most recent posts

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
                // Call the fetchPosts function to get the last 5 most recent posts
                $profileInfo->fetchTopics($_SESSION["user_id"]);

                // Display the last 5 most recent posts

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
                // Call the fetchPosts function to get the last 5 most recent posts
                $profileInfo->fetchCategories($_SESSION["user_id"]);

                // Display the last 5 most recent posts

                ?>
            </div>
        </div>
    </div>
</div>