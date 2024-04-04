<?php
include('../Backend/database.php');
include('../Backend/config.php');
include('../Backend/header.php');







try {
    // Query to fetch categories with their threads and last post information
    $category_query = "SELECT c.cat_id, c.cat_name, t.thread_id, t.thread_title, t.thread_description, 
                            p.post_id, p.user_id AS last_user_id, p.date_created AS last_post_date, 
                            u.username AS last_username
                       FROM categories c
                       LEFT JOIN threads t ON c.cat_id = t.cat_id
                       LEFT JOIN posts p ON t.thread_id = p.thread_id
                       LEFT JOIN users u ON p.user_id = u.user_id
                       GROUP BY t.thread_id
                       ORDER BY t.thread_id";

    $category_statement = $db->prepare($category_query);
    $category_statement->execute();
    $categories = $category_statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>


<base href="community.php" />

<meta name="keywords" content="" />
<meta name="description" content="" />

<link rel="stylesheet" href="../../css/styles.css" />

<title>KnBForums</title>

<div class="community-page-wrapper">
    <div class="community-content-wrapper">
        <div class="community-content">

            <div class="sidebar">
                <div id="globalsearch" class="globalsearch">
                    <form action=" " method="post" id="navbar_search" class="navbar_search">
                        <input type="hidden" name="do" value="process" />
                        <input type="text" value="" name="query" class="textbox" tabindex="99" />
                        <input type="submit" class="searchbutton" name="submit" onclick=" " tabindex="100" />
                    </form>
                </div>
                <ul class="advanced_search">
                    <li><a href=" " accesskey=" " id="advanced-search-link">Advanced Search</a></li>
                </ul>
            </div>
        </div>
        <form action="#" method="post" id="notices" class="notices">
            <input type="hidden" name="do" value="dismissnotice" />
            <input type="hidden" name="securitytoken" value="guest" />
            <input type="hidden" id="dismiss_notice_hidden" name="dismiss_noticeid" value="" />
            <input type="hidden" name="url" value="" />
            <ol>
                <li id="notice-item">
                    You have to <a href="User Pages/register.php" id="register-notice-link">register</a> before you can post: click the register link to proceed. To start viewing messages, select the forum that you want to visit from the selection below.
                </li>
            </ol>
        </form>
        <div id="pagetitle">
            <h1 id="forum-title">KnBForums</h1>
            <p id="welcome-message" class="description">Welcome to the KnBForums.</p>
        </div>
        <!-- main -->




        <?php foreach ($categories as $category) : ?>
            <div class="forum">
                <div class='category-container'>
                    <h2>
                        <span class='category-name'><?php echo $category['cat_name']; ?></span>
                        <span class='forum-last-post'>Last Post</span>
                        <a class="collapse" href="#top">Collapse</a>
                    </h2>
                </div>
                <ol>


                    <table class="last-post-table">
                        <tr>
                            <td class="thread-data-container">
                                <?php if ($category['thread_id']) : ?>
                                    <h2><a href="../Backend/showthread.php?thread_id=<?php echo $category['thread_id']; ?>"><?php echo $category['thread_title']; ?></a></h2>
                                    <p><?php echo $category['thread_description']; ?></p>
                                <?php endif; ?>

                            </td>
                            <td class="last-post-info">
                                <h4>Last post title:</h4>
                                <div>
                                    <p><a href="#">Go to last post</a></p>
                                    <?php if ($category['last_post_date']) : ?>
                                        <p>Last post by <strong><?php echo $category['last_username']; ?></strong> at <?php echo $category['last_post_date']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    </table>


                </ol>

            </div>

        <?php endforeach; ?>
    </div>
</div>

<?php
include('../Backend/footer.php');
?>