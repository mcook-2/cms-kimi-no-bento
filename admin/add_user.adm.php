<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');

// Fetch roles from the database
$stmt_roles = $db->query("SELECT role_id, role_name FROM roles");
$roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role'];

    // Validate form data
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($role_id)) {
        $errors[] = "Role is required.";
    }

    // If no errors, proceed with user creation
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $insertStmt = $db->prepare("INSERT INTO users (username, email, password_hash, role_id) VALUES (:username, :email, :password, :role_id)");
        $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $insertStmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);

        if ($insertStmt->execute()) {
            // Redirect to the admin dashboard 
            header("Location: dashboard.adm.php");
            exit();
        } else {
            $errors[] = "Error creating user.";
        }
    }
}

include('header.adm.php');
?>

<?php include('sidebar.adm.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <h2>Add User</h2>
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="add_user.adm.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
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


</body>

<?php include('footer.adm.php'); ?>