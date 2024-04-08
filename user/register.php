<?php
include('../inc/config.inc.php');
include('../inc/header.inc.php');

// Initialize variables to store submitted values
$usernameValue = '';
$emailValue = '';

// Check if there are any errors stored in the session
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']); // Remove errors from session to prevent displaying them again on refresh

    // Retrieve submitted data from session
    if (isset($_SESSION['submitted_data'])) {
        $submittedData = $_SESSION['submitted_data'];
        $usernameValue = isset($submittedData['username']) ? $submittedData['username'] : '';
        $emailValue = isset($submittedData['email']) ? $submittedData['email'] : '';
    }
}
?>

<h2>Registration Form</h2>

<form action="../backend/register_user.php" method="post">
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($usernameValue); ?>">
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($emailValue); ?>">
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </div>
    <div>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password">
    </div>
    <?php if (!empty($errors)) : ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div>
        <input type="submit" value="Register">
    </div>
</form>

<?php
// Include footer
include('../inc/footer.inc.php');
?>