<?php
include('../inc/config.inc.php');
include('../inc/database.inc.php');

// handle topic img 
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Check if the topic_id is set and not empty

    if (isset($_GET['topic_id'])) {
        $topic_id = $_GET['topic_id'];
        // Prepare the SQL query to select img_url from topics table
        $query = "SELECT img_url FROM topics WHERE topic_id = :topic_id AND topic_starter_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        // Check if img_url exists
        if ($result && isset($result['img_url'])) {
            // replace '\' (was causing issues)
            $img_url = str_replace('\\', '/', $result['img_url']);

            // Add '../' to the beginning to find upload path 
            $img_url = '../' . $img_url;

            // Construct the thumbnail URL
            $thumbnail_url = dirname($img_url) . '/' . pathinfo($img_url, PATHINFO_FILENAME) . '_thumbnail.' . pathinfo($img_url, PATHINFO_EXTENSION);

            // Unlink the original image file and its thumbnail
            if (unlink($img_url) && unlink($thumbnail_url)) {

                // Prepare the update query to set img_url to null
                $update_query = "UPDATE topics SET img_url = NULL WHERE topic_id = :topic_id AND topic_starter_id = :user_id";
                $update_stmt = $db->prepare($update_query);
                $update_stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
                $update_stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

                // Execute the update statement
                if ($update_stmt->execute()) {
                    // Update successful
                    header("location: ../user/user_edit.php?topic_id=$topic_id");
                    exit();
                } else {
                    // Update failed
                    header("location: ../user/user_edit.php?topic_id=$topic_id");
                    exit();
                }
            } else {
                // Unlink failed
                header("location: ../user/user_edit.php?topic_id=$topic_id");
                exit();
            }
        } else {
            // img_url not found or topic does not belong to the user
            header("location: ../user/account.php");
            exit();
        }
    } else {
        // topic_id is not set or empty
        header("location: ../user/account.php");
    }
}

// handle user pfp img 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the action is to delete the profile picture
    if (isset($_POST['deleteProfile']) && $_POST['deleteProfile'] === 'delete_pfp') {
        // Get the user ID from the POST data
        $userId = $_POST['userId'];

        // default img to replace user pfp
        $defaultImages = [
            "../img/default_imgs/dog.jpg",
            "../img/default_imgs/cat_bento.png",
            "../img/default_imgs/default_bento_2.png"
        ];

        // Check if the submitted user ID matches the session user ID
        if ($userId != $_SESSION['user_id']) {
            // If not, redirect to home page
            header("Location: ../index.php");
            exit();
        }

        // Fetch the user's current profile picture URL from the database
        $query = "SELECT profiles_pfp FROM profiles WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (in_array($result['profiles_pfp'], $defaultImages)) {
            // If the current profile picture is one of the default images, redirect back to account page
            header("Location: ../user/account.php");
            exit();
        }


        if ($result && isset($result['profiles_pfp'])) {
            // Delete the profile picture file from the server
            $pfp_url = str_replace('\\', '/',  $result['profiles_pfp']);

            $pfp_thumbnail_url = dirname($pfp_url) . '/' . pathinfo($pfp_url, PATHINFO_FILENAME) . '_thumbnail.' . pathinfo($pfp_url, PATHINFO_EXTENSION);

            if (unlink($pfp_url) && unlink($pfp_thumbnail_url)) {
                // Update the profile picture set to random default img
                $defaultImages = [
                    "../img/default_imgs/dog.jpg",
                    "../img/default_imgs/cat_bento.png",
                    "../img/default_imgs/default_bento_2.png"
                ];
                $newProfilePicture = $defaultImages[array_rand($defaultImages)];

                // Update the profile picture URL in the database
                $updateQuery = "UPDATE profiles SET profiles_pfp = :new_profile_picture WHERE user_id = :user_id";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->bindParam(':new_profile_picture', $newProfilePicture, PDO::PARAM_STR);
                $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);


                if ($updateStmt->execute()) {
                    // Redirect back to the profile page after successful deletion
                    header("Location: ../user/account.php?=true");
                    exit();
                } else {
                    // Error updating the database
                    header("Location: ../user/account.php?=error");
                }
            } else {
                // Error deleting the profile picture file
                header("Location: ../user/account.php?=error");
            }
        } else {
            // User or profile picture not found
            header("Location: ../user/account.php?=error");
        }
    } else {
        // Invalid action
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
}
