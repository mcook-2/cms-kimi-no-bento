<?php
include_once('../inc/config.inc.php');
include('../inc/header.inc.php');

include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');
include('../classes/profileinfo-view.classes.php');

$profileInfo = new ProfileInfoView();
?>

<section class="profile">
    <div class="container">
        <div class="profile-settings">
            <h3 class="mb-4">PROFILE SETTINGS</h3>
            <form action="../inc/profileinfo.inc.php" method="post">
                <div class="form-group">
                    <label for="about">About Section</label>
                    <textarea class="form-control" name="about" id="about" rows="6" placeholder="Describe yourself..."><?php $profileInfo->fetchAbout($_SESSION["user_id"]); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="introtitle">Page Intro Title</label>
                    <input type="text" class="form-control" name="introtitle" id="introtitle" placeholder="Title..." value="<?php $profileInfo->fetchTitle($_SESSION["user_id"]); ?>">
                </div>
                <div class="form-group">
                    <label for="introtext">Page Intro Text</label>
                    <textarea class="form-control" name="introtext" id="introtext" rows="6" placeholder="Introduction text..."><?php $profileInfo->fetchText($_SESSION["user_id"]); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
            </form>
        </div>
    </div>
</section>

<script>
    tinymce.init({
        selector: 'textarea', // change this value according to your HTML
        menubar: 'file edit view'
    });
</script>

<?php
include('../inc/footer.inc.php');
?>