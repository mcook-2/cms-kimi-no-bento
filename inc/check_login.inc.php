<?php


define('login_url', 'http://localhost:31337/wd2/Project/cms-kimi-no-bento/');

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header('Location: ' . login_url . 'user/login.php');
    exit; // Make sure to exit after redirecting to prevent further execution
}
