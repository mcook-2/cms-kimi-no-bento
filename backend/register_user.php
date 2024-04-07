<?php
include('../inc/config.php');
include('../inc/database.php');

// Include the FormValidator class
include('../backend/form_validator.php');

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instantiate FormValidator with POST data
    $validator = new FormValidator($_POST);

    // Validate form data
    $errors = $validator->validate();

    if (empty($errors)) {

        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // role_id 935 is user
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, '935')");

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        // keeping this here when i figure out hashing
        // Hash password before storing it in the database
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // $stmt->bindParam(':password', $hashedPassword);

        // Execute the statement
        $stmt->execute();

        unset($_SESSION['submitted_data']);

        // Redirect user to login page after successful registration
        header("location: ../index.php"); // Redirect to the success page
        exit();
    } else {
        // If there are validation errors, store errors and submitted data in session and redirect back to the registration form
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['submitted_data'] = $_POST; // Store submitted data in session
        header("location: ../user/register.php"); // Redirect back to the registration form
        exit();
    }
}
