<?php
require_once('../inc/authenticate.inc.php');
include('../inc/database.inc.php');



if (isset($_POST['entity']) && isset($_POST['id'])) {
    $entity = $_POST['entity'];
    $id = $_POST['id'];

    switch ($entity) {
        case 'topic':
            $table = 'topics';
            $id_column = 'topic_id';
            break;
        case 'post':
            $table = 'posts';
            $id_column = 'post_id';
            break;
        case 'category':
            $table = 'categories';
            $id_column = 'category_id';
            break;
        case 'user':
            $table = 'users';
            $id_column = 'user_id';
            break;
        default:
            echo "Invalid entity type.";
            exit();
    }



    $stmt = $db->prepare("DELETE FROM $table WHERE $id_column = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();


    // Check if deletion was successful
    if ($stmt->rowCount() > 0) {
        header("Location: dashboard.adm.php");
        exit();
    } else {
        echo "Deletion unsuccessful.";
        exit();
    }
} else {
    echo "Entity type or ID not provided.";
    exit();
}
