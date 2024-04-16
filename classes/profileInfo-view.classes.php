<?php


class ProfileInfoView extends ProfileInfo
{

    public function fetchAbout($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);

        echo $profileInfo[0]["profiles_about"];
    }

    public function fetchTitle($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);

        echo $profileInfo[0]["profiles_introtitle"];
    }

    public function fetchText($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);

        echo $profileInfo[0]["profiles_introtext"];
    }

    public function fetchCategories($user_id)
    {
        $categories = $this->getUserCategories($user_id);

        foreach ($categories as $category) {
            echo $category["name"] . "<br>";
        }
    }

    public function fetchTopics($user_id)
    {
        $topics = $this->getUserTopics($user_id);

        foreach ($topics as $topic) {
            echo $topic["title"];
            echo $topic["topic_content"];
        }
    }

    public function fetchPosts($user_id)
    {
        $posts = $this->getUserPosts($user_id);

        foreach ($posts as $post) {
            echo $post["title"] . "<br>";
            echo $post["content"] . "<br>";
        }
    }
}
