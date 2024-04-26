<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');
include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');
include('../classes/profileinfo-view.classes.php');
include('header.adm.php');
include('sidebar.adm.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    $user_id = $_POST['user_id'];
    if (
        isset($_POST['user_id'], $_POST['username'], $_POST['email'], $_POST['role']) &&
        !empty($_POST['user_id']) && !empty($_POST['username']) &&
        !empty($_POST['email']) && !empty($_POST['role'])
    ) {
        // Sanitize user input

        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $role = htmlspecialchars($_POST['role']);

        // Update user data in the database
        $stmt = $db->prepare("UPDATE users SET username = :username, email = :email, role_id = (SELECT role_id FROM roles WHERE role_name = :role) WHERE user_id = :user_id");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirect back to edit_user.adm.php with success message
            header("Location: view_users.adm.php?user_id=$user_id&success=true");
            exit();
        } else {
            header("Location: edit_user.adm.php?user_id=$user_id&error=updatefail");
            exit();
        }
    } else {
        header("Location: edit_user.adm.php?user_id=$user_id&error=nullfields");
        exit();
    }
} else {
    header("Location: dashboard.adm.php?error=invalid_request");
    exit();
}
include('footer.adm.php');
