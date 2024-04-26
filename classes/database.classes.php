<?php

class Database
{


    protected function connection()
    {
        // Pre-set database connection parameters
        $dsn = 'mysql:host=db-mysql-knb-database-74278-do-user-16431368-0.c.db.ondigitalocean.com;dbname=defaultdb;charset=utf8';
        $user = 'doadmin';
        $pass = 'AVNS_p2uK4i-g1iTffL1b6YB';

        try {
            $db = new PDO($dsn, $user, $pass);
            // Set PDO to throw exceptions on error
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            // Handle connection errors
            throw new Exception("Error connecting to the database: " . $e->getMessage());
        }
    }
}
