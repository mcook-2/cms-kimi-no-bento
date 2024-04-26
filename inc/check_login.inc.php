<?php


define('login_url', '/cms-kimi-no-bento/');

if (!isset($_SESSION['loggedin']) || !isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header('Location: ' . login_url . 'user/login.php');
    exit;
}
