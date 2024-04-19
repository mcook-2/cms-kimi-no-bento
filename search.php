<?php
include('inc/database.inc.php');
include_once('inc/config.inc.php');
include('inc/header.inc.php');

// Define the number of items per page
$itemsPerPage = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 5;

// Get the current page number, default to 1 if not set
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Initialize the search term variable

$searchTerm = !empty($_GET['query']) ? $_GET['query'] : '';
// Check if the search query is not empty
if (!empty($_GET['query'])) {
    $searchTerm = $_GET['query'];
}


// Prepare the SQL query for posts with pagination
$stmtPosts = $db->prepare("
    SELECT 
        posts.post_id AS post_id,
        posts.title AS post_title,
        posts.content AS post_content,
        posts.date_created AS post_date_created,
        topics.title AS topic_title, -- Select the topic title
        topics.topic_id,
        categories.name AS category_name,
        users.username AS post_author,
        profiles.profiles_pfp AS post_author_pfp
    FROM 
        posts
    LEFT JOIN 
        users ON posts.author_id = users.user_id
    LEFT JOIN 
        profiles ON users.user_id = profiles.user_id
    LEFT JOIN 
        topics ON posts.topic_id = topics.topic_id
    LEFT JOIN 
        categories ON topics.category_id = categories.category_id
    WHERE 
        users.username LIKE :searchTerm 
        OR topics.title LIKE :searchTerm
        OR categories.name LIKE :searchTerm 
        OR posts.content LIKE :searchTerm
        OR posts.title LIKE :searchTerm
    ORDER BY posts.date_created DESC
");

// Bind search term parameter for posts
$stmtPosts->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
// Bind pagination parameters

// Execute the statement for posts
$stmtPosts->execute();

// Fetch all rows for posts from the result set
$posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);



// Prepare the SQL query for posts with pagination
$pgPosts = $db->prepare("
    SELECT 
        posts.post_id AS post_id,
        posts.title AS post_title,
        posts.content AS post_content,
        posts.date_created AS post_date_created,
        topics.title AS topic_title, -- Select the topic title
        topics.topic_id,
        categories.name AS category_name,
        users.username AS post_author,
        profiles.profiles_pfp AS post_author_pfp
    FROM 
        posts
    LEFT JOIN 
        users ON posts.author_id = users.user_id
    LEFT JOIN 
        profiles ON users.user_id = profiles.user_id
    LEFT JOIN 
        topics ON posts.topic_id = topics.topic_id
    LEFT JOIN 
        categories ON topics.category_id = categories.category_id
    WHERE 
        users.username LIKE :searchTerm 
        OR topics.title LIKE :searchTerm
        OR categories.name LIKE :searchTerm 
        OR posts.content LIKE :searchTerm
        OR posts.title LIKE :searchTerm
");

// Bind search term parameter for posts
$pgPosts->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$pgPosts->execute();

$totalPosts = $pgPosts->fetchAll(PDO::FETCH_ASSOC);


// Count total number of results after fetching the data
// $totalPostResults = $pgPosts->rowCount();
// var_dump($totalPostResults);


// Prepare the SQL query for topics with pagination
$stmtTopics = $db->prepare("
    SELECT 
        topics.topic_id AS topic_id,
        topics.title AS topic_title,
        topics.topic_content AS topic_content,
        topics.date_created AS topic_date_created,
        topics.topic_id,
        categories.name AS category_name,
        users.username AS topic_starter,
        profiles.profiles_pfp AS topic_starter_pfp
    FROM 
        topics
    LEFT JOIN 
        users ON topics.topic_starter_id = users.user_id
    LEFT JOIN 
        profiles ON users.user_id = profiles.user_id
    LEFT JOIN 
        categories ON topics.category_id = categories.category_id
    WHERE 
        users.username LIKE :searchTerm 
        OR topics.title LIKE :searchTerm
        OR categories.name LIKE :searchTerm 
        OR topics.topic_content LIKE :searchTerm
    ORDER BY topics.date_created DESC
");
// Bind search term parameter for topics
$stmtTopics->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);

// Execute the statement for topics
$stmtTopics->execute();

// Fetch all rows for topics from the result set
$topics = $stmtTopics->fetchAll(PDO::FETCH_ASSOC);

$pgTopics = $db->prepare("
    SELECT 
        topics.topic_id AS topic_id,
        topics.title AS topic_title,
        topics.topic_content AS topic_content,
        topics.date_created AS topic_date_created,
        topics.topic_id,
        categories.name AS category_name,
        users.username AS topic_starter,
        profiles.profiles_pfp AS topic_starter_pfp
    FROM 
        topics
    LEFT JOIN 
        users ON topics.topic_starter_id = users.user_id
    LEFT JOIN 
        profiles ON users.user_id = profiles.user_id
    LEFT JOIN 
        categories ON topics.category_id = categories.category_id
    WHERE 
        users.username LIKE :searchTerm 
        OR topics.title LIKE :searchTerm
        OR categories.name LIKE :searchTerm 
        OR topics.topic_content LIKE :searchTerm
    ORDER BY topics.date_created DESC
");
// Bind search term parameter for topics
$pgTopics->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);

// Execute the statement for topics
$pgTopics->execute();

// Fetch all rows for topics from the result set
$totalTopics = $pgTopics->fetchAll(PDO::FETCH_ASSOC);
// $totalTopicResults = $pgPosts->rowCount();
//var_dump($totalTopicResults);

// Merge the arrays of total posts and total topics
$pagetotals = array_merge($totalPosts, $totalTopics);

// Calculate the total number of results
$totalResults = count($pagetotals);

//var_dump($totalResults);

// Merge posts and topics into one array
$results = array_merge($posts, $topics);

// Sort the merged array by date_created
usort($results, function ($a, $b) {
    // Get the date_created for both posts and topics
    $dateA = isset($a['post_date_created']) ? $a['post_date_created'] : $a['topic_date_created'];
    $dateB = isset($b['post_date_created']) ? $b['post_date_created'] : $b['topic_date_created'];

    // Compare the dates
    return strtotime($dateB) - strtotime($dateA);
});

// Calculate total number of pages
$totalPages = ceil($totalResults / $itemsPerPage);


$paginationLinks = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($page == $i) ? 'active' : '';
    // Construct the pagination link
    $link = 'search.php?';

    $link .= 'query=' . urlencode($searchTerm) . '&';

    $link .= 'page=' . $i;
    if ($itemsPerPage) {
        $link .= '&items_per_page=' . $itemsPerPage;
    }
    // Append the link to $paginationLinks
    $paginationLinks .= "<li class='page-item $activeClass'><a class='page-link' href='$link'>$i</a></li>";
}


?>



<?php
$startIndex = ($page - 1) * $itemsPerPage;
for ($i = 0; $startIndex + $i < count($results) && $i < $itemsPerPage; $i++) {
    $result = $results[$startIndex + $i];
    // Your code to display each item goes here
    if (isset($result['post_id'])) : ?>
        <!-- Display post -->
        <div id="post_<?php echo $result['post_id']; ?>" class="searchitem-community-post row">
            <div class="col-auto">
                <div class="user-icon-bordered rounded-circle">
                    <img src="<?php echo $result['post_author_pfp']; ?>" alt="<?php echo $result['post_author']; ?>" class="rounded-circle" width="50" height="50">
                </div>
            </div>
            <div class="col">
                <div class="searchitem-text">
                    <h4 class="searchitem-title">
                        <span><?php echo $result['post_author']; ?></span>
                        <?php
                        echo "commented in";
                        $url = "show_topic.php?topic_id=" . $result['topic_id'];
                        $postNum = "#" . $result['post_id'];
                        $title =  $result['topic_title']; // Concatenating post and topic titles
                        ?>
                        <a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
                    </h4>

                    <div class="searchitem-title text-content">Title: <a href="<?php echo $url . $postNum ?>" title="<?php echo $result['post_title']; ?>"><?php echo $result['post_title']; ?></a> </div>
                    <div class="searchitem-body text-content"><?php echo $result['post_content']; ?></div>
                    <div class=" searchitem-meta"><?php echo $result['post_date_created']; ?> in <a href="#"><?php echo $result['category_name']; ?></a></div>
                </div>
            </div>
        </div>
    <?php elseif (isset($result['topic_id'])) : ?>
        <!-- Display topic -->
        <div id="topic_<?php echo $result['topic_id']; ?>" class="searchitem-community-post row">
            <div class="col-auto">
                <div class="user-icon-bordered rounded-circle">
                    <img src="<?php echo $result['topic_starter_pfp']; ?>" alt="<?php echo $result['topic_starter']; ?>" class="rounded-circle" width="50" height="50">
                </div>
            </div>
            <div class="col">
                <div class="searchitem-text">
                    <h4 class="searchitem-title">
                        <span><?php echo $result['topic_starter']; ?></span>
                        <?php
                        echo "created ";
                        $url = "show_topic.php?topic_id=" . $result['topic_id'];
                        $title = $result['topic_title'];
                        ?>
                        <a href="<?php echo $url; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
                    </h4>
                    <div class="searchitem-body text-content"><?php echo $result['topic_content']; ?></div>
                    <div class="searchitem-meta"><?php echo $result['topic_date_created']; ?> in <a href="#"><?php echo $result['category_name']; ?></a></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php }

?>

<!-- Display pagination links -->
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?= $paginationLinks ?>

    </ul>
    <div class="mb-2">
        <!-- Display total number of results -->
        <span>Total Results: <?= $totalResults ?></span>
        <!-- Form with links for choosing items per page -->
        <form method="GET" class="d-inline ml-3">
            <span class="mr-2 <?= $itemsPerPage == 1 ? 'selected' : '' ?>"><a href="?items_per_page=1">1</a></span>
            <span class="mr-2 <?= $itemsPerPage == 5 ? 'selected' : '' ?>"><a href="?items_per_page=5">5</a></span>
            <span class="mr-2 <?= $itemsPerPage == 10 ? 'selected' : '' ?>"><a href="?items_per_page=10">10</a></span>
            <span class="mr-2 <?= $itemsPerPage == 20 ? 'selected' : '' ?>"><a href="?items_per_page=20">20</a></span>
            <span class="<?= $itemsPerPage == 50 ? 'selected' : '' ?>"><a href="?items_per_page=50">50</a></span>
        </form>
    </div>

</nav>

<?php

?>
<?php include('inc/footer.inc.php'); ?>