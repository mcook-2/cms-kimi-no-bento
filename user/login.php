<?php

include('../inc/database.inc.php');
include('../inc/config.inc.php');
include('../inc/header.inc.php');

include('../classes/form_validator.classes.php');
include('../classes/form_sanitizer.classes.php');

// Initialize variables for form data
$username_or_email = $password = "";
$username_or_email_err = $password_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sanitizedData = FormSanitizer::sanitize($_POST);
    $validator = new FormValidator($sanitizedData);

    if (empty($errors)) {
        // Validate username/email
        if (empty(trim($sanitizedData["username_or_email"]))) {
            $username_or_email_err = "Please enter username or email.";
        } else {
            $username_or_email = trim($sanitizedData["username_or_email"]);
        }

        // Validate password
        if (empty(trim($sanitizedData["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $password = trim($sanitizedData["password"]);
        }


        // Check input errors before database lookup
        if (empty($username_or_email_err) && empty($password_err)) {

            $sql = "SELECT user_id, role_id, username, email, password_hash FROM users WHERE username = :username OR email = :email";

            if ($stmt = $db->prepare($sql)) {
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
                            $db_password = $row["password_hash"];

                            // Verify password
                            if (password_verify($password, $db_password)) {
                                // Password is correct, store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["user_id"] = $id;
                                $_SESSION["role_id"] = $role_id;
                                $_SESSION["username"] = $username;
                                $_SESSION["email"] = $email;

                                // Redirect user to home page
                                header("location: ../index.php");
                                exit();
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

                unset($stmt);
            }
        }
    }

    unset($db);
}
?>

<!-- Login form -->
<div class="login_container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Login</li>
            </ol>
        </nav>
        <div class="row justify-content-center border-0">
            <div class="col-md-6">
                <div class="login_container p-4">
                    <h2>Login</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div <?php echo (!empty($username_or_email_err)) ? 'has-error' : ''; ?>>
                            <label for="username_or_email">Username or Email:</label>
                            <input type="text" class="form-control" id="username_or_email" name="username_or_email" value="<?php echo htmlspecialchars($username_or_email); ?>">
                            <span class="loginerr"><?php echo htmlspecialchars($username_or_email_err); ?></span>
                        </div>
                        <div <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>>
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="loginerr"><?php echo htmlspecialchars($password_err); ?></span>
                        </div>

                        <button class="btn btn-primary w-100 px-4" type="submit">Login</button>
                    </form>
                    <div class="col-md-auto  ">
                        <p>Don't have an account? <a href="register.php">Register here</a></p>
                    </div>
                    <!-- User details dropdown -->
                    <div class="dropdown mt-4">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-toggle="collapse" data-target="#userDetails" aria-expanded="false" aria-controls="userDetails">
                            User Details
                        </button>
                        <div class="collapse" id="userDetails">
                            <h4>User</h4>
                            <p>Username: <strong>funguy1337</strong></p>
                            <p>Email: fake@gmail.com</p>
                            <p>Pass: <strong>PASSword123</strong></p>
                        </div>
                    </div>

                    <!-- Admin details dropdown -->
                    <div class="dropdown mt-4">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="adminDropdown" data-toggle="collapse" data-target="#adminDetails" aria-expanded="false" aria-controls="adminDetails">
                            Admin Details
                        </button>
                        <div class="collapse" id="adminDetails">
                            <h4>Admin</h4>
                            <p>Username: <strong>big_boss</strong></p>
                            <p>Email: what_a_thrill.snakeeater@gmail.com</p>
                            <p>Pass: <strong>But youre s0 supreme!</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include('../inc/footer.inc.php');
?>