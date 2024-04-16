<?php
define('BASE_URL', 'http://localhost:31337/wd2/Project/cms-kimi-no-bento/');
define('CSS_URL', 'http://localhost:31337/wd2/Project/cms-kimi-no-bento/CSS/');
define('IMG_URL', 'http://localhost:31337/wd2/Project/cms-kimi-no-bento/IMG/');
define('TINYMCE_URL', 'http://localhost:31337/wd2/Project/cms-kimi-no-bento/tinymce/js/tinymce/');



function logout()
{
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the homepage or login page
    header("Location: " . BASE_URL . "index.php");
    exit;
}

// Check if the logout button is clicked
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
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>bootstrap-grid.min.css" />
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>styles.css" />

    <script src="<?php echo TINYMCE_URL; ?>tinymce.min.js"></script>


</head>

<body>
    <div>
        <h3>Session Information</h3>
        <pre><?php var_dump($_SESSION); ?></pre>
    </div>




    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="<?php echo IMG_URL; ?>logo kimi no bento.png" alt="Logo" width="200" height="200" class="d-inline-block">
            Kimi no Bento
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr auto">
                <li class="nav-item"><a class="nav-link" href=" <?php echo BASE_URL; ?>index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>community.php?category=all">Community</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>about.php">About Us</a></li>

                <?php if (isset($_SESSION['user_id'])) : ?>
                    <!-- If logged in, show the account and logout links -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>user/account.php"><?php echo $_SESSION['username']; ?></a></li>
                    <li>
                        <form method="post">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    </li>
                <?php else : ?>
                    <!-- If not logged in, show the login and register links -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>user/login.php">Login / Register </a></li>
                <?php endif; ?>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    </header>