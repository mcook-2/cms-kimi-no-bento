<?php
define('DB_DSN', 'mysql:host=sql206.byethost3.com;dbname=b3_36435767_knb_database;charset=utf8');
define('DB_USER', 'b3_36435767');
define('DB_PASS', '36eW.qyruYu2SJ*');

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
