<?php
// Include database connection

include('../inc/database.php'); // Assuming your database configuration is stored in this file
include('../inc/config.php');
include('../inc/header.php');

// Start session

// Initialize variables for form data
$username_or_email = $password = "";
$username_or_email_err = $password_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username/email
    if (empty(trim($_POST["username_or_email"]))) {
        $username_or_email_err = "Please enter username or email.";
    } else {
        $username_or_email = trim($_POST["username_or_email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before database lookup
    if (empty($username_or_email_err) && empty($password_err)) {
        // Prepare a SELECT statement
        $sql = "SELECT user_id, role_id, username, email, password FROM users WHERE username = :username OR email = :email";

        if ($stmt = $db->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_username = $param_email = $username_or_email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username/email exists
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["user_id"];
                        $role_id = $row["role_id"];
                        $username = $row["username"];
                        $email = $row["email"];
                        $db_password = $row["password"];

                        // Compare entered password with the password stored in the database
                        if ($password === $db_password) {

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["role_id"] = $role_id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;

                            // Redirect user to home page
                            header("location: ../index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if username/email doesn't exist
                    $username_or_email_err = "No account found with that username or email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close database connection
    unset($db);
}
?>

<!-- Login form -->
<div class="login_container">
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div <?php echo (!empty($username_or_email_err)) ? 'has-error' : ''; ?>">
            <label for="username_or_email">Username or Email:</label>
            <input type="text" class="form-control" id="username_or_email" name="username_or_email" value="<?php echo $username_or_email; ?>">
            <span><?php echo $username_or_email_err; ?></span>
        </div>
        <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
            <span><?php echo $password_err; ?></span>
        </div>
        <button type="submit">Login</button>
    </form>
    <p>Username:<strong>funguy1337</strong></p>
    <p>Email: fake@gmail.com</p>
    <p>Pass: <strong>PASSword123</strong></p>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php
// Include footer
include('../inc/footer.php');
?>