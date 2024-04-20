<?php
include_once('../inc/config.inc.php');
include('../inc/header.inc.php');

// variables to store submitted values
$usernameValue = '';
$emailValue = '';

// Check if there are any errors stored in the session
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']); // Remove errors from session to prevent displaying them again on refresh

    // Retrieve submitted data to fill inputs
    if (isset($_SESSION['submitted_data'])) {
        $submittedData = $_SESSION['submitted_data'];
        $usernameValue = isset($submittedData['username']) ? $submittedData['username'] : '';
        $emailValue = isset($submittedData['email']) ? $submittedData['email'] : '';
        unset($_SESSION['submitted_data']);
    }
}
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Registration</li>
        </ol>
    </nav>

    <div class="row justify-content-center border-bottom-0">
        <div class="col-md-6 ">
            <h2 class="mt-4 mb-3 text-center ">Registration Form</h2>
            <form action="../backend/register_user.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($usernameValue); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($emailValue); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                </div>
                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>

    <div class="row p-1 justify-content-center ">
        <div class="col-md-6 ">
            <div class="row justify-content-center border-bottom-0">
                <div class="col-md-auto">
                    <p class="text-center">Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include('../inc/footer.inc.php');
?>