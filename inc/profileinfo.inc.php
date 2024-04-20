<?php

include_once('config.inc.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_SESSION["user_id"];
    $username = $_SESSION["username"];
    $about = htmlspecialchars($_POST["about"], ENT_QUOTES, "UTF-8");
    $introTitle = htmlspecialchars($_POST["introtitle"], ENT_QUOTES, "UTF-8");
    $introText = htmlspecialchars($_POST["introtext"], ENT_QUOTES, "UTF-8");

    include('../classes/database.classes.php');
    include('../classes/profileinfo.classes.php');
    include('../classes/profileinfo-contr.classes.php');

    $profileInfo = new ProfileInfoContr($id, $username);

    $profileInfo->updateProfileInfo($about, $introTitle, $introText);


    header("location: ../user/account.php?error=none");
}
