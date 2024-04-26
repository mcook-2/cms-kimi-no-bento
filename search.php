<?php
include('inc/database.inc.php');
include_once('inc/config.inc.php');
include('inc/header.inc.php');

// Define the number of items per page
$itemsPerPage = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 5;

// Get the current page number, default to 1 if not set
$page = isset($_GET['page']) ? $_GET['page'] : 1;


$searchTerm = !empty($_GET['query']) ? $_GET['query'] : '';
// Check if the search query is not empty
if (!empty($_GET['query'])) {
    $searchTerm = $_GET['query'];
}

$selectedCategory = !empty($_GET['category']) ? $_GET['category'] : '';

// Check if a category is selected
if (!empty($selectedCategory)) {
    // If a category is selected, only search within that category
    $categoryCondition = " AND categories.name = :selectedCategory ";
} else {
    // If no category is selected, search in all categories
    $categoryCondition = "";
}

$stmt = $db->prepare("SELECT name FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

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
    (users.username LIKE :searchTerm 
    OR topics.title LIKE :searchTerm
    OR posts.content LIKE :searchTerm
    OR posts.title LIKE :searchTerm)
    $categoryCondition
    ORDER BY posts.date_created DESC
");
$stmtPosts->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
if (!empty($selectedCategory)) {
    $stmtPosts->bindValue(':selectedCategory', $selectedCategory, PDO::PARAM_STR);
}
$stmtPosts->execute();
$posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);

//SQL query for posts pagination
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
        (users.username LIKE :searchTerm 
        OR topics.title LIKE :searchTerm
        OR posts.content LIKE :searchTerm
        OR posts.title LIKE :searchTerm)
        $categoryCondition
");
$pgPosts->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
if (!empty($selectedCategory)) {
    $pgPosts->bindValue(':selectedCategory', $selectedCategory, PDO::PARAM_STR);
}
$pgPosts->execute();
$totalPosts = $pgPosts->fetchAll(PDO::FETCH_ASSOC);

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
        (users.username LIKE :searchTerm 
        OR topics.title LIKE :searchTerm
        OR topics.topic_content LIKE :searchTerm)
        $categoryCondition
    ORDER BY topics.date_created DESC
");
$stmtTopics->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
if (!empty($selectedCategory)) {
    $stmtTopics->bindValue(':selectedCategory', $selectedCategory, PDO::PARAM_STR);
}
$stmtTopics->execute();
$topics = $stmtTopics->fetchAll(PDO::FETCH_ASSOC);

//SQL query for topics pagination
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
        (users.username LIKE :searchTerm 
        OR topics.title LIKE :searchTerm
        OR topics.topic_content LIKE :searchTerm)
        $categoryCondition
    ORDER BY topics.date_created DESC
");
$pgTopics->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
if (!empty($selectedCategory)) {
    $pgTopics->bindValue(':selectedCategory', $selectedCategory, PDO::PARAM_STR);
}
$pgTopics->execute();
$totalTopics = $pgTopics->fetchAll(PDO::FETCH_ASSOC);

// Merge the arrays of total posts and total topics
$pagetotals = array_merge($totalPosts, $totalTopics);

// Calculate the total number of results
$totalResults = count($pagetotals);

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
    $link .= 'category=' . urlencode($selectedCategory) . '&';

    $link .= 'page=' . $i;
    if ($itemsPerPage) {
        $link .= '&items_per_page=' . $itemsPerPage;
    }
    // Append the link to $paginationLinks
    $paginationLinks .= "<li class='page-item $activeClass'><a class='page-link' href='$link'>$i</a></li>";
}

// start index for pagination
$startIndex = ($page - 1) * $itemsPerPage;

?>

<!-- Breadcrumb navigation -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Search Results for "<?php echo htmlspecialchars($searchTerm); ?>" in "<?php echo htmlspecialchars(empty($selectedCategory) ? "All Categories" : $selectedCategory); ?>"</li>
        </ol>
    </nav>

    <!-- Dropdown for selecting category -->
    <form action="search.php" method="get">
        <div class="form-group">
            <input type="text" class="form-control" name="query" placeholder="Search" aria-label="Search" aria-describedby="search-btn1">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="search-btn2">Search</button>
            </div>
            <label for="categorySelect">Select Category:</label>
            <select id="categorySelect" class="form-control" name="category" style="height: auto;">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <!-- table for search query results -->
    <div class="row border-0">
        <div class=" col border-0">
            <table class="table ">
                <tbody>
                    <?php for ($i = 0; $startIndex + $i < count($results) && $i < $itemsPerPage; $i++) :
                        $result = $results[$startIndex + $i];
                        $isPost = isset($result['post_id']);
                        $id = $isPost ? 'post_' . $result['post_id'] : 'topic_' . $result['topic_id'];
                    ?>
                        <tr id="<?php echo $id; ?>" class="searchitem-community-post ">
                            <td>
                                <div class="row border-0 bg-light">
                                    <div class="col-auto border-0 ">
                                        <div class="user-icon-bordered rounded-circle">
                                            <img src="cms-kimi-no-bento/<?php echo $isPost ? $result['post_author_pfp'] : $result['topic_starter_pfp']; ?>" alt="<?php echo $isPost ? $result['post_author'] : $result['topic_starter']; ?>" class="rounded-circle" width="50" height="50">
                                        </div>
                                    </div>
                                    <div class="col border-0">
                                        <h4 class="searchitem-title">
                                            <span><?php echo $isPost ? $result['post_author'] : $result['topic_starter']; ?></span>
                                            <?php echo $isPost ? 'commented in' : 'created'; ?>
                                            <a href="show_topic.php?topic_id=<?php echo $result['topic_id']; ?>" title="<?php echo $result['topic_title']; ?>"><?php echo strip_tags(htmlspecialchars_decode($result['topic_title'])); ?></a>
                                        </h4>
                                        <div class="searchitem-body text-content">
                                            <?php if ($isPost) : ?>
                                                Title: <a href="show_topic.php?topic_id=<?php echo $result['topic_id']; ?>#<?php echo $result['post_id']; ?>" title="<?php echo strip_tags(htmlspecialchars_decode($result['post_title'])); ?>"><?php echo strip_tags(htmlspecialchars_decode($result['post_title'])); ?></a>
                                                <br>
                                            <?php endif; ?>
                                            <?php echo $isPost ? strip_tags(htmlspecialchars_decode($result['post_content'])) : strip_tags(htmlspecialchars_decode($result['topic_content'])); ?>
                                        </div>
                                        <div class="searchitem-meta">
                                            <?php echo $isPost ? $result['post_date_created'] : $result['topic_date_created']; ?> in <a href="#"><?php echo $result['category_name']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
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
</div>
<?php include('inc/footer.inc.php'); ?>