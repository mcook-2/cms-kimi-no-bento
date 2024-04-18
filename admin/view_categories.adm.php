<?php
// Check authentication here
// If the user is not authenticated, redirect them to the login page
include('../inc/database.inc.php');

$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'category_id';
$orderDir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $db->prepare("SELECT categories.*, users.username 
                    FROM categories 
                    LEFT JOIN users ON categories.user_id = users.user_id
                    WHERE users.username LIKE :searchTerm OR categories.name LIKE :searchTerm 
                    ORDER BY $orderBy $orderDir");
$stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<main role=" main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>View Categories</h2>
    <form method="get" class="form-inline mb-2">
        <div class="form-group mr-2">
            <label class="font-weight-bold mr-2" for="search">Search:</label>
            <input type="text" name="search" id="search" class="form-control" value="<?= htmlspecialchars($searchTerm) ?>">
        </div>
        <div class="form-group mr-2">
            <label class="font-weight-bold mr-2" for="order_by">Order by:</label>
            <select name="order_by" id="order_by" class="form-control">
                <option value="category_id" <?= $orderBy == 'category_id' ? 'selected' : '' ?>>Category id</option>
                <option value="name" <?= $orderBy == 'name' ? 'selected' : '' ?>>Category Name</option>
                <option value="username" <?= $orderBy == 'username' ? 'selected' : '' ?>>Username</option>
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
        <button type="submit" class="btn btn-primary">Sort</button>
    </form>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th class="col-1 <?= $orderBy == 'category_id' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Category id</th>
                <th class="col-1 <?= $orderBy == 'name' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Category Name</th>
                <th class="col-1 <?= $orderBy == 'username' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Username</th>
                <th class="col-1 <?= $orderBy == 'date_created' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category) : ?>
                <tr>
                    <th scope="row" class="col-1"><?= $category['category_id'] ?></th>
                    <td class="col-1"><?= highlightSearchTerm($category['name'], $searchTerm) ?></td>
                    <td class="col-1"><?= highlightSearchTerm($category['username'], $searchTerm) ?></td>
                    <td class="col-1"><?= $category['date_created'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php include('footer.adm.php'); ?>
</body>

</html>