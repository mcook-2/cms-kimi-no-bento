<?php
// Check authentication here
// If the user is not authenticated, redirect them to the login page
include('../inc/database.inc.php');

// Check if sorting criteria is set
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'post_id';
$orderDir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $db->prepare("SELECT posts.post_id, posts.title, posts.content, posts.date_created, 
                    categories.name AS 'Category Name', topics.title AS 'Topic Name', 
                    users.username 
                    FROM posts 
                    LEFT JOIN users ON posts.author_id = users.user_id 
                    LEFT JOIN topics ON posts.topic_id = topics.topic_id 
                    LEFT JOIN categories ON topics.category_id = categories.category_id
                    WHERE users.username LIKE :searchTerm OR topics.title LIKE :searchTerm
                        OR categories.name LIKE :searchTerm OR posts.content LIKE :searchTerm
                        OR posts.title LIKE :searchTerm
                    ORDER BY $orderBy $orderDir");
$stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

function highlightSearchTerm($text, $searchTerm)
{
    if (!empty($searchTerm)) {
        return preg_replace('/(' . preg_quote($searchTerm, '/') . ')/i', '<span style="background-color:#90ff75">$1</span>', $text);
    }
    return $text;
}

// Include header
include('header.adm.php');
?>

<?php include('sidebar.adm.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>View Posts</h2>
    <form method="get" class="form-inline mb-2">
        <div class="form-group mr-2">
            <label class="font-weight-bold mr-2" for="search">Search:</label>
            <input type="text" name="search" id="search" class="form-control" value="<?= htmlspecialchars($searchTerm) ?>">
        </div>
        <div class="form-group mr-2">
            <label class="font-weight-bold mr-2" for="order_by">Order by: </label>
            <select name="order_by" id="order_by" class="form-control">
                <option value="post_id" <?= $orderBy == 'post_id' ? 'selected' : '' ?>>Post id</option>
                <option value="categories.name" <?= $orderBy == 'categories.name' ? 'selected' : '' ?>>Category Name</option>
                <option value="topics.title" <?= $orderBy == 'topics.title' ? 'selected' : '' ?>>Topic Name</option>
                <option value="users.username" <?= $orderBy == 'users.username' ? 'selected' : '' ?>>Username</option>
                <option value="title" <?= $orderBy == 'title' ? 'selected' : '' ?>>Title</option>
                <option value="date_created" <?= $orderBy == 'date_created' ? 'selected' : '' ?>>Date Created</option>
            </select>
        </div>
        <div class="form-group mr-2">
            <label class="font-weight-bold mr-2" for="order_dir">Order direction:</label>
            <select name="order_dir" id="order_dir" class="form-control">
                <option value="ASC" <?= $orderDir == 'ASC' ? 'selected' : '' ?>>ASC</option>
                <option value="DESC" <?= $orderDir == 'DESC' ? 'selected' : '' ?>>DESC</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Search & Sort</button>
    </form>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th class="col-1 <?= $orderBy == 'post_id' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Post id</th>
                <th class="col-1 <?= $orderBy == 'categories.name' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Category Name</th>
                <th class="col-1 <?= $orderBy == 'topics.title' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Topic Name</th>
                <th class="col-1 <?= $orderBy == 'users.username' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Username</th>
                <th class="col-1 <?= $orderBy == 'title' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Title</th>
                <th class="col">Content</th>
                <th class="col-1 <?= $orderBy == 'date_created' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) : ?>
                <tr>
                    <th scope="row" class="col-1"><?= $post['post_id'] ?></th>
                    <td class="col-1"><?= highlightSearchTerm($post['Category Name'], $searchTerm) ?></td>
                    <td class="col-1"><?= highlightSearchTerm($post['Topic Name'], $searchTerm) ?></td>
                    <td class="col-1"><?= highlightSearchTerm($post['username'], $searchTerm) ?></td>
                    <td class="col-1"><?= highlightSearchTerm($post['title'], $searchTerm) ?></td>
                    <td class="col"><?= highlightSearchTerm($post['content'], $searchTerm) ?></td>
                    <td class="col-1"><?= $post['date_created'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>



<?php include('footer.adm.php'); ?>
</body>

</html>