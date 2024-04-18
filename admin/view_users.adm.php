<?php
// Include necessary files
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

// Query to fetch users with their roles from the database
$stmt = $db->prepare("SELECT users.user_id, users.username, users.email, roles.role_name, users.date_created 
                    FROM users 
                    INNER JOIN roles ON users.role_id = roles.role_id
                    WHERE users.username LIKE :searchTerm OR users.email LIKE :searchTerm
                    ORDER BY $orderBy $orderDir");
$stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            <button type="submit" class="btn btn-primary">Search & Sort</button>
        </form>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th class="<?= $orderBy == 'user_id' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Topic id</th>
                <th class="<?= $orderBy == 'username' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Username</th>
                <th class="<?= $orderBy == 'email' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Email</th>
                <th class="<?= $orderBy == 'role_name' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Role</th>
                <th class="<?= $orderBy == 'date_created' ? ($orderDir == 'ASC' ? 'sorted-asc' : 'sorted-desc') : '' ?>">Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <th scope="row"><?= $user['user_id'] ?></th>
                    <td><?= highlightSearchTerm($user['username'], $searchTerm) ?></td>
                    <td><?= highlightSearchTerm($user['email'], $searchTerm) ?></td>
                    <td><?= $user['role_name'] ?></td>
                    <td><?= $user['date_created'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>




<?php include('footer.adm.php'); ?>
</body>

</html>