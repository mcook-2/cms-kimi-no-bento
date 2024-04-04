<?php
define('BASE_URL', 'http://localhost:31337/wd2/Project/cms-kimi-no-bento/PHP/Pages/');
define('CSS_URL', 'http://localhost:31337/wd2/Project/cms-kimi-no-bento/CSS/');


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
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>styles.css" />

</head>

<body>
    <div>
        <h3>Session Information</h3>
        <pre><?php var_dump($_SESSION); ?></pre>
    </div>
    <header>
        <nav>
            <div class="logo">
                <a href="<?php echo BASE_URL; ?>index.php">Kimi no Bento</a>
            </div>
            <ul class="nav_links">
                <li><a href="<?php echo BASE_URL; ?>index.php">Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>menu.php">Menu</a></li>
                <li><a href="<?php echo BASE_URL; ?>order.php">Order Now</a></li>
                <li><a href="<?php echo BASE_URL; ?>community.php">Community</a></li>
                <li><a href="<?php echo BASE_URL; ?>blog.php">Blog</a></li>
                <li><a href="<?php echo BASE_URL; ?>about.php">About Us</a></li>

                <?php if (isset($_SESSION['user_id'])) : ?>
                    <!-- If logged in, show the account and logout links -->
                    <li><a href="<?php echo BASE_URL; ?>User_Pages/account.php">Account</a></li>
                    <li>
                        <form method="post">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    </li>
                <?php else : ?>
                    <!-- If not logged in, show the login and register links -->
                    <li><a href="<?php echo BASE_URL; ?>User Pages/login.php">Login / Register </a></li>
                <?php endif; ?>

            </ul>

        </nav>
    </header>