<?php

class Database
{


    protected function connection()
    {
        // Pre-set database connection parameters
        $dsn = 'mysql:host=localhost;dbname=knb_database;charset=utf8';
        $user = 'cms_user';
        $pass = 'youllnevergeussthispassworditslong';

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
