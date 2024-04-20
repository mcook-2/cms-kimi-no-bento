<?php
// Include necessary files
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');

// Fetch roles from the database
$stmt_roles = $db->query("SELECT role_id, role_name FROM roles");
$roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role']; // Get selected role_id

    // Insert the new user into the database
    $insertStmt = $db->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)");
    $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
    $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $insertStmt->bindParam(':password', $password, PDO::PARAM_STR); // You might want to hash the password
    $insertStmt->bindParam(':role_id', $role_id, PDO::PARAM_INT); // Bind role_id
    $insertStmt->execute();

    // Redirect to the admin dashboard or any other page as needed
    header("Location: dashboard.adm.php");
    exit();
}

// Include header
include('header.adm.php');
?>

<?php include('sidebar.adm.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>Add User</h2>
    <form method="post" action="add_user.adm.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role">
                <?php foreach ($roles as $role) : ?>
                    <option value="<?= $role['role_id'] ?>"><?= $role['role_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</main>

<?php include('footer.adm.php'); ?>
</body>

</html>