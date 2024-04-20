<?php
// Include necessary files and initialize database connection
include('../inc/database.inc.php');
include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');
include('../classes/profileinfo-view.classes.php');
include('header.adm.php');
include('sidebar.adm.php');

// Check if user_id is provided in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Query to fetch user data with role from the database
    $stmt = $db->prepare("SELECT users.*, roles.role_name FROM users INNER JOIN roles ON users.role_id = roles.role_id WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists
    if ($user) {
        // Display user edit form
?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h2>Edit User</h2>
            <form action="update_user.adm.php" method="POST">
                <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= $user['username'] ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= $user['email'] ?>">
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select name="role" id="role" class="form-control">
                        <?php
                        // Fetch and populate options dynamically based on roles from the database
                        $stmtRoles = $db->prepare("SELECT role_name FROM roles");
                        $stmtRoles->execute();
                        $roles = $stmtRoles->fetchAll(PDO::FETCH_COLUMN);
                        foreach ($roles as $role) {
                            echo "<option value=\"$role\"";
                            if ($user['role_name'] == $role) {
                                echo " selected";
                            }
                            echo ">$role</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </main>
<?php
    } else {
        echo "User not found.";
    }
} else {
    echo "User ID not provided.";
}

// Include footer
include('footer.adm.php');
?>