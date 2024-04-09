<?php
include('../inc/config.inc.php');
include('../inc/database.inc.php');

// Include the FormValidator and FormSanitizer classes
include('../classes/form_validator.classes.php');
include('../classes/form_sanitizer.classes.php');
include('../classes/database.classes.php');
include('../classes/profileinfo.classes.php');
include('../classes/profileinfo-contr.classes.php');

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form data
    $sanitizedData = FormSanitizer::sanitize($_POST);

    // Instantiate FormValidator with sanitized data
    $validator = new FormValidator($sanitizedData);

    // Validate form data
    $errors = $validator->validate();

    if (empty($errors)) {
        // Extract sanitized data
        $username = $sanitizedData["username"];
        $email = $sanitizedData["email"];
        $password = $sanitizedData["password"];
        $confirm_password = $sanitizedData["confirm_password"];

        // Check if username or email already exists
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $existing_user = $stmt->fetch();

        if ($existing_user) {
            // Check if the existing user has the same username or email
            if ($existing_user['username'] === $username) {
                // Username already exists
                $errors['existing_user'] = "Username already exists.";
            } elseif ($existing_user['email'] === $email) {
                // Email already exists
                $errors['existing_user'] = "Email already exists.";
            }

            $_SESSION['errors'] = $errors;
            $_SESSION['submitted_data'] = $_POST; // Store submitted data in session
            header("location: ../user/register.php"); // Redirect back to the registration form
            exit();
        }

        // Insert sanitized data into the database
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, '935')");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Retrieve the last inserted ID
        $new_user_id = $db->lastInsertId();

        // Retrieve the inserted user data using the last inserted ID and username
        $stmt = $db->prepare("SELECT * FROM users WHERE user_id = :check_id AND username = :username");
        $stmt->bindParam(':check_id', $new_user_id);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Fetch the inserted user data
        $inserted_user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user was successfully inserted and the fetched data is valid
        if ($inserted_user && $inserted_user['username'] === $username) {
            // Insertion successful, and inserted data matches

            // Access the role ID from the fetched user data
            $role_id = $inserted_user['role_id'];
            $_SESSION["role_id"] = $role_id;

            // Store user details in session
            $_SESSION["loggedin"] = true;
            $_SESSION["user_id"] = $new_user_id;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;

            // Create default profile
            $profileInfo = new ProfileInfoContr($new_user_id, $username);
            $profileInfo->defaultProfileInfo();

            // Clear submitted data from session
            unset($_SESSION['submitted_data']);
            unset($stmt);

            // Redirect to the success page
            header("location: ../index.php");
            exit();
        }
    } else {
        // If there are validation errors, store errors and submitted data in session and redirect back to the registration form
        $_SESSION['errors'] = $errors;
        $_SESSION['submitted_data'] = $_POST; // Store submitted data in session
        header("location: ../user/register.php"); // Redirect back to the registration form
        exit();
    }
}
