<?php
// Include necessary files
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');
include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');
include('../classes/profileinfo-view.classes.php');
include('header.adm.php');

// Check if sorting criteria is set
$orderBy = isset($_GET['order_by']) ? $_GET['order_by'] : 'user_id';
$orderDir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC';

// Check if search criteria is set
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Define the number of items per page
$itemsPerPage = isset($_GET['items_per_page']) ? intval($_GET['items_per_page']) : 10;


// Get the current page number, default to 1 if not set
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset
$offset = ($page - 1) * $itemsPerPage;

// Query to fetch users with their roles from the database
$stmt = $db->prepare("SELECT users.user_id, users.username, users.email, roles.role_name, users.date_created 
                    FROM users 
                    INNER JOIN roles ON users.role_id = roles.role_id
                    WHERE users.username LIKE :searchTerm OR users.email LIKE :searchTerm
                    ORDER BY $orderBy $orderDir
                    LIMIT :offset, :itemsPerPage");
$stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pgStmt = $db->prepare("SELECT users.user_id, users.username, users.email, roles.role_name, users.date_created 
                        FROM users 
                        INNER JOIN roles ON users.role_id = roles.role_id
                        WHERE users.username LIKE :searchTerm OR users.email LIKE :searchTerm
                        ORDER BY $orderBy $orderDir");
$pgStmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$pgStmt->execute();
$pgStmt->fetchAll(PDO::FETCH_ASSOC);

// Count total number of results after fetching the data
$totalResults = $pgStmt->rowCount();

// Calculate total number of pages
$totalPages = ceil($totalResults / $itemsPerPage);

// Pagination links
$paginationLinks = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($page == $i) ? 'active' : '';
    // Include $itemsPerPage and $searchTerm as parameters in the pagination links
    $paginationLinks .= "<li class='page-item $activeClass'><a class='page-link' href='?page=$i&items_per_page=$itemsPerPage&search=" . urlencode($searchTerm) . "'>$i</a></li>";
}



function highlightSearchTerm($text, $searchTerm)
{
    if (!empty($searchTerm)) {
        return preg_replace('/(' . preg_quote($searchTerm, '/') . ')/i', '<span style="background-color:#90ff75">$1</span>', $text);
    }
    return $text;
}


?>

<?php include('sidebar.adm.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>View Users</h2>

    <div class="mb-2">
        <form method="get" class="form-inline">
            <div class="form-group mr-2">
                <label class="font-weight-bold mr-2" for="search">Search:</label>
                <input type="text" name="search" id="search" class="form-control" value="<?= htmlspecialchars($searchTerm) ?>">
            </div>
            <div class="form-group mr-2">
                <label class="font-weight-bold mr-2" for="order_by">Order by:</label>
                <select name="order_by" id="order_by" class="form-control">
                    <option value="user_id" <?= $orderBy == 'user_id' ? 'selected' : '' ?>>User id</option>
                    <option value="username" <?= $orderBy == 'username' ? 'selected' : '' ?>>Username</option>
                    <option value="email" <?= $orderBy == 'email' ? 'selected' : '' ?>>Email</option>
                    <option value="role_name" <?= $orderBy == 'role_name' ? 'selected' : '' ?>>Role</option>
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
            <button type="submit" class="btn btn-primary">Search & Sort</button>
        </form>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th class="<?= $orderBy == 'user_id' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">User id</th>
                <th class="<?= $orderBy == 'username' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Username</th>
                <th class="<?= $orderBy == 'email' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Email</th>
                <th class="<?= $orderBy == 'role_name' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Role</th>
                <th class="<?= $orderBy == 'date_created' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Date Created</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <th scope="row"><?= $user['user_id'] ?></th>
                    <td><?= highlightSearchTerm(htmlspecialchars($user['username']), $searchTerm) ?></td>
                    <td><?= highlightSearchTerm(htmlspecialchars($user['email']), $searchTerm) ?></td>
                    <td><?= highlightSearchTerm(htmlspecialchars($user['role_name']), $searchTerm) ?></td>
                    <td><?= htmlspecialchars($user['date_created']) ?></td>
                    <td>
                        <a href="edit_user.adm.php?user_id=<?= $user['user_id'] ?>">Edit</a>
                        <!-- Form for deletion -->
                        <form action="delete.adm.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="entity" value="user">
                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                            <button type="submit" class="btn btn-link text-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
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

<?php include('footer.adm.php'); ?>
</body>

</html>