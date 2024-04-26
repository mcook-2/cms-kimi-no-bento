<?php
define('DB_DSN', 'mysql:host=db-mysql-knb-database-74278-do-user-16431368-0.c.db.ondigitalocean.com;dbname=defaultdb;charset=utf8');
define('DB_USER', 'doadmin');
define('DB_PASS', 'AVNS_p2uK4i-g1iTffL1b6YB');

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
