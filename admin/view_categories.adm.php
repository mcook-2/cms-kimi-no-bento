<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');

$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'category_id';
$orderDir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
}

// Define the number of items per page
$itemsPerPage = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 10;

// Get the current page number, default to 1 if not set
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset
$offset = ($page - 1) * $itemsPerPage;

$stmt = $db->prepare("SELECT categories.*
                    FROM categories 
                    WHERE  categories.name LIKE :searchTerm 
                    ORDER BY " . (isset($_GET['id']) ? "categories.category_id = :categoryId DESC, " : "") . "$orderBy $orderDir
                    LIMIT :offset, :itemsPerPage");

if (isset($_GET['id'])) {
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
}
$stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pagination query
$pgStmt = $db->prepare("SELECT categories.* 
                    FROM categories 
                    WHERE categories.name LIKE :searchTerm 
                    ORDER BY $orderBy $orderDir");
$pgStmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$pgStmt->execute();
$pgStmt->fetchAll(PDO::FETCH_ASSOC);

$totalResults = $pgStmt->rowCount();

// Calculate total number of pages
$totalPages = ceil($totalResults / $itemsPerPage);

// Pagination links
$paginationLinks = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($page == $i) ? 'active' : '';
    $paginationLinks .= "<li class='page-item $activeClass'><a class='page-link' href='?page=$i&items_per_page=$itemsPerPage&search=" . urlencode($searchTerm) . "'>$i</a></li>";
}

function highlightSearchTerm($text, $searchTerm)
{
    if (!empty($searchTerm)) {
        return preg_replace('/(' . preg_quote($searchTerm, '/') . ')/i', '<span style="background-color:#90ff75">$1</span>', $text);
    }
    return $text;
}

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
        <input type="hidden" name="items_per_page" value="<?= $itemsPerPage ?>">
        <button type="submit" class="btn btn-primary">Sort</button>
    </form>
    <div>
        <a href="create_category.adm.php" class="btn btn-success mr-5 p-1 m-auto d-inline">Create new Category</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th class="col-1 <?= $orderBy == 'category_id' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Category id</th>
                <th class="col-1 <?= $orderBy == 'name' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Category Name</th>
                <th class="col-1 <?= $orderBy == 'date_created' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Date Created</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category) : ?>
                <tr>
                    <th><?= isset($categoryId) ? highlightSearchTerm($category['category_id'], $categoryId) : $category['category_id'] ?></th>
                    <td class="col-1"><?= highlightSearchTerm($category['name'], $searchTerm) ?></td>
                    <td class="col-1"><?= $category['date_created'] ?></td>
                    <td class="col-1"><a href="edit_categories.adm.php?category_id=<?= $category['category_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <form action="delete.adm.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="entity" value="category">
                            <input type="hidden" name="id" value="<?= $category['category_id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
</main>
</body>
<?php include('footer.adm.php'); ?>