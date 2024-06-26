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
            header("Location: ../index.php");
            exit();
        }
    }

    public function getProfilePicture($user_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT profiles_pfp FROM profiles WHERE user_id = ?');
            $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // Check if a profile picture exists for the user
            if ($result && isset($result['profiles_pfp'])) {
                return $result['profiles_pfp']; // Return the profile picture path directly
            } else {
                // Return a default profile picture if none is found
                return '../img/default imgs/cat_bento.png';
            }
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }


    public function updateProfilePfp($filePath, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('UPDATE profiles SET profiles_pfp = ? WHERE user_id = ?');
            $stmt->bindValue(1, $filePath, PDO::PARAM_STR);
            $stmt->bindValue(2, $user_id, PDO::PARAM_INT);

            $stmt->execute();
            return true; // Return true if update was successful
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }


    protected function setNewProfileInfo($profileAbout, $profileTitle, $profileText, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('UPDATE profiles SET profiles_about = ?, profiles_introtitle = ?, profiles_introtext = ? WHERE user_id = ?');
            $stmt->bindValue(1, $profileAbout, PDO::PARAM_STR);
            $stmt->bindValue(2, $profileTitle, PDO::PARAM_STR);
            $stmt->bindValue(3, $profileText, PDO::PARAM_STR);
            $stmt->bindValue(4, $user_id, PDO::PARAM_INT);
            $stmt->execute();
            // No need to fetch data after an update operation
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }

    protected function setProfileInfo($profileAbout, $profileTitle, $profileText, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('INSERT INTO profiles (profiles_about, profiles_introtitle, profiles_introtext, user_id) VALUES (?, ?, ?, ?)');
            $stmt->bindValue(1, $profileAbout, PDO::PARAM_STR);
            $stmt->bindValue(2, $profileTitle, PDO::PARAM_STR);
            $stmt->bindValue(3, $profileText, PDO::PARAM_STR);
            $stmt->bindValue(4, $user_id, PDO::PARAM_INT);
            $stmt->execute();
            // No need to fetch data after an insert operation
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }

    protected function _updateProfileInfo($profileAbout, $profileTitle, $profileText, $user_id)
    {
        try {
            $stmt = $this->connection()->prepare('UPDATE profiles SET profiles_about = ?, profiles_introtitle = ?, profiles_introtext = ? WHERE user_id = ?');
            $stmt->bindValue(1, $profileAbout, PDO::PARAM_STR);
            $stmt->bindValue(2, $profileTitle, PDO::PARAM_STR);
            $stmt->bindValue(3, $profileText, PDO::PARAM_STR);
            $stmt->bindValue(4, $user_id, PDO::PARAM_INT);
            $stmt->execute();
            // No need to fetch data after an update operation
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }

    public function updateTopicImg($filePath, $topic_id)
    {
        try {
            $stmt = $this->connection()->prepare('UPDATE topics SET img_url = ? WHERE topic_id = ?');
            $stmt->bindValue(1, $filePath, PDO::PARAM_STR);
            $stmt->bindValue(2, $topic_id, PDO::PARAM_INT);

            $stmt->execute();
            return true; // Return true if update was successful
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }

    public function getTopicImg($topic_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT img_url FROM topics WHERE topic_id = ?');
            $stmt->bindValue(1, $topic_id, PDO::PARAM_INT);
            $stmt->execute();
            $img_url = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $img_url[0]["img_url"];
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }



    protected function getUserTopics($user_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT topic_id, title, topic_content, category_id, img_url FROM topics WHERE topic_starter_id = ?');
            $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $topics;
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }




    protected function getUserPosts($user_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT post_id, title, content FROM posts WHERE author_id = ?');
            $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }

    public function getCategories()
    {
        try {
            $stmt = $this->connection()->prepare('SELECT * FROM categories ');
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }

    public function getCurrentTopicCategory($topic_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT c.name FROM categories c INNER JOIN topics t ON c.category_id = t.category_id WHERE t.topic_id = ?');
            $stmt->execute([$topic_id]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category['name'];
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }



    public function getCurrentPostTopic($post_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT t.title FROM topics t INNER JOIN posts p ON t.topic_id = p.topic_id WHERE p.post_id = ?');
            $stmt->execute([$post_id]);
            $topic = $stmt->fetch(PDO::FETCH_ASSOC);
            return $topic['title'];
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }



    public function getUserTopicsId($user_id, $topic_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT topic_id, title, topic_content, category_id FROM topics WHERE topic_starter_id = ? AND topic_id = ?');
            $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $topic_id, PDO::PARAM_INT);
            $stmt->execute();
            $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $topics;
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }


    public function getUserPostsId($user_id, $post_id)
    {
        try {
            $stmt = $this->connection()->prepare('SELECT post_id, title, content FROM posts WHERE author_id = ? AND post_id = ?');
            $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $post_id, PDO::PARAM_INT);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        } catch (PDOException $e) {
            header("Location: ../index.php");
            exit();
        }
    }
}
