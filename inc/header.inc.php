<?php

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
// Detect the current hostname
$hostname = $_SERVER['HTTP_HOST'];
// Construct the BASE_URL based on the detected protocol and hostname
define('BASE_URL', $protocol . '://' . $hostname . '/');

define('CSS_URL', BASE_URL . 'CSS/');
define('IMG_URL', BASE_URL . 'img/');
define('TINYMCE_URL', BASE_URL . 'lib/tinymce/js/tinymce/');

function logout()
{
    // Unset all session variables
    $_SESSION = array();

    session_destroy();

    header("Location: " . BASE_URL . "index.php");
    exit;
}

if (isset($_POST['logout'])) {
    logout();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>styles.css" />
    <script src="<?php echo TINYMCE_URL; ?>tinymce.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="<?php echo IMG_URL; ?>logo_kimi_no_bento.png" alt="Logo" width="200" height="200" class="d-inline-block">
            Kimi no Bento
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto justify-content-between">
                <li class="nav-item"><a class="nav-link" href=" <?php echo BASE_URL; ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>community.php?category=all">Community</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>about.php">About Us</a></li>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <!-- If logged in, show the account, admin, and logout links -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>user/account.php"><?php echo $_SESSION['username']; ?></a></li>
                    <?php if ($_SESSION['role_id'] === 666) : ?>
                        <!-- Show admin link only if the user is an admin -->
                        <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>admin.php">Admin</a></li>
                    <?php endif; ?>
                    <li>
                        <form method="post">
                            <button type="submit" name="logout" class="btn btn-link">Logout</button>
                        </form>
                    </li>
                <?php else : ?>
                    <!-- If not logged in, show the login and register links -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>user/login.php">Login / Register</a></li>
                <?php endif; ?>
            </ul>
            <form class="form-inline my-7 my-lg-0" action="<?php echo BASE_URL; ?>search.php" method="GET">
                <input type="text" class="form-control" name="query" placeholder="Search" aria-label="Search" aria-describedby="search-btn1">
                <input type="hidden" name="page" value="1"> <!-- hidden input for page number -->
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="search-btn1">Search</button>
                </div>
            </form>
        </div>
    </nav>