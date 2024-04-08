<?php


class ProfileInfo extends Database
{
    protected function getProfileInfo($user_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT * FROM profiles WHERE users_id = ?;');
            $stmt->execute(array($user_id));
            $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $profileData;
        } catch (PDOException $e) {

            // Reset the statement
            $stmt = null;

            // Redirect back to index 
            header("Location: ../index.php");
            exit();
        }
    }

    protected function setNewProfileInfo($profileAbout, $profiletitle, $profileText, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('UPDATE profiles SET profiles_about = ?, profiles_introtitle = ?, profiles_introtext = ? WHERE user_id = ? ;');
            $stmt->execute(array($profileAbout, $profiletitle, $profileText, $user_id));
            $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $profileData;
        } catch (PDOException $e) {

            // Reset the statement
            $stmt = null;

            // Redirect back to index 
            header("Location: ../index.php");
            exit();
        }
    }

    protected function setProfileInfo($profileAbout, $profileTitle, $profileText, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('INSERT INTO profiles  (profiles_about, profiles_introtitle, profiles_introtext, user_id) VALUES (?,?,?,?) ;');
            $stmt->execute(array($profileAbout, $profileTitle, $profileText, $user_id));
            $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $profileData;
        } catch (PDOException $e) {

            // Reset the statement
            $stmt = null;

            // Redirect back to index 
            header("Location: ../index.php");
            exit();
        }
    }
}
