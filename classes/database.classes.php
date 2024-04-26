<?php

class Database
{

    protected function connection()
    {
        // Pre-set database connection parameters
        $dsn = 'mysql:host=localhost;dbname=id22091600_knb;charset=utf8';
        $user = 'id22091600_kenzo';
        $pass = 'H3adbang!23';

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
