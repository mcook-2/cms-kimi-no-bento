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
    <div class="profile-bg">
        <div class="container">
            <div class="profile-settings">
                <h3>PROFILE SETTINGS</h3>
                <p>Change your about section here!!</p>

                <form action="../inc/profileinfo.inc.php" method="post">
                    <div class="form-group">
                        <textarea class="form-control" name="about" rows="10" placeholder="Profile about section.."><?php $profileInfo->fetchAbout($_SESSION["user_id"]); ?></textarea>
                    </div>
                    <br>
                    <p>Change your page intro here!</p>
                    <br>
                    <div class="form-group">
                        <input type="text" class="form-control" name="introtitle" placeholder="Profile title..." value="<?php $profileInfo->fetchTitle($_SESSION["user_id"]); ?>">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="introtext" rows="10" placeholder="Profile intro text ...."><?php $profileInfo->fetchText($_SESSION["user_id"]); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">SAVE</button>
                </form>
            </div>
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