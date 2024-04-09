<?php

class ProfileInfo extends Database
{
    protected function getProfileInfo($user_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT * FROM profiles WHERE user_id = ?');
            $stmt->bindValue(1, $user_id, PDO::PARAM_INT); // Bind user_id parameter as integer
            $stmt->execute();
            $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $profileData;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log the error, redirect, etc.)
            header("Location: ../index.php");
            exit();
        }
    }

    protected function setNewProfileInfo($profileAbout, $profileTitle, $profileText, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('UPDATE profiles SET profiles_about = ?, profiles_introtitle = ?, profiles_introtext = ? WHERE user_id = ?');
            $stmt->bindValue(1, $profileAbout, PDO::PARAM_STR); // Bind profileAbout parameter as string
            $stmt->bindValue(2, $profileTitle, PDO::PARAM_STR); // Bind profileTitle parameter as string
            $stmt->bindValue(3, $profileText, PDO::PARAM_STR); // Bind profileText parameter as string
            $stmt->bindValue(4, $user_id, PDO::PARAM_INT); // Bind user_id parameter as integer
            $stmt->execute();
            // No need to fetch data after an update operation
        } catch (PDOException $e) {
            // Handle the exception (e.g., log the error, redirect, etc.)
            header("Location: ../index.php");
            exit();
        }
    }

    protected function setProfileInfo($profileAbout, $profileTitle, $profileText, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('INSERT INTO profiles (profiles_about, profiles_introtitle, profiles_introtext, user_id) VALUES (?, ?, ?, ?)');
            $stmt->bindValue(1, $profileAbout, PDO::PARAM_STR); // Bind profileAbout parameter as string
            $stmt->bindValue(2, $profileTitle, PDO::PARAM_STR); // Bind profileTitle parameter as string
            $stmt->bindValue(3, $profileText, PDO::PARAM_STR); // Bind profileText parameter as string
            $stmt->bindValue(4, $user_id, PDO::PARAM_INT); // Bind user_id parameter as integer
            $stmt->execute();
            // No need to fetch data after an insert operation
        } catch (PDOException $e) {
            // Handle the exception (e.g., log the error, redirect, etc.)
            header("Location: ../index.php");
            exit();
        }
    }

    protected function _updateProfileInfo($profileAbout, $profileTitle, $profileText, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('UPDATE profiles SET profiles_about = ?, profiles_introtitle = ?, profiles_introtext = ? WHERE user_id = ?');
            $stmt->bindValue(1, $profileAbout, PDO::PARAM_STR); // Bind profileAbout parameter as string
            $stmt->bindValue(2, $profileTitle, PDO::PARAM_STR); // Bind profileTitle parameter as string
            $stmt->bindValue(3, $profileText, PDO::PARAM_STR); // Bind profileText parameter as string
            $stmt->bindValue(4, $user_id, PDO::PARAM_INT); // Bind user_id parameter as integer
            $stmt->execute();
            // No need to fetch data after an update operation
        } catch (PDOException $e) {
            // Handle the exception (e.g., log the error, redirect, etc.)
            header("Location: ../index.php");
            exit();
        }
    }
}
