<?php


class ProfileInfoView extends ProfileInfo
{
    // Fetch about information for a user
    public function fetchAbout($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);
        return $profileInfo[0]["profiles_about"];
    }


    // Fetch title information for a user
    public function fetchTitle($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);
        return $profileInfo[0]["profiles_introtitle"];
    }


    // Fetch text information for a user
    public function fetchText($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);
        return $profileInfo[0]["profiles_introtext"];
    }


    // Fetch 'all' categories 
    public function fetchCategories($user_id)
    {
        $categories = $this->getCategories($user_id);
        return $categories;
    }


    // Fetch current category for topic
    public function fetchCurrentCategoryTopic($topic_id)
    {
        $categoryTopic = $this->getCurrentTopicCategory($topic_id);
        return $categoryTopic;
    }


    // Fetch current post of topic
    public function fetchCurrentPostTopic($post_id)
    {
        $postTopic = $this->getCurrentPostTopic($post_id);
        return $postTopic;
    }


    // Fetch all topics of a user (row data inculded)
    public function fetchTopics($user_id)
    {
        $topics = $this->getUserTopics($user_id);
        return $topics;
    }


    // Fetch all posts of a user (row data inculded)
    public function fetchPosts($user_id)
    {
        $posts = $this->getUserPosts($user_id);
        return $posts;
    }


    // Fetch profile picture for a user
    public function fetchProfilePicture($user_id)
    {
        $profilePicture = $this->getProfilePicture($user_id);
        return $profilePicture;
    }
}
