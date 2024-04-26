<?php
define('DB_DSN', 'mysql:host=localhost;dbname=id22091600_knb;charset=utf8');
define('DB_USER', 'id22091600_kenzo');
define('DB_PASS', 'H3adbang!23');

//  PDO is PHP Data Objects
//  mysqli <-- BAD. 
//  PDO <-- GOOD.
try {
    // Try creating new PDO connection to MySQL.
    $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    //,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
} catch (PDOException $e) {
    print "Error: " . $e->getMessage();
    die(); // Force execution to stop on errors.
    // When deploying to production you should handle this
    // situation more gracefully. ¯\_(ツ)_/¯
}
