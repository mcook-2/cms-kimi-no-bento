<?php


class ProfileInfoView extends ProfileInfo
{

    public function fetchAbout($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);

        return $profileInfo[0]["profiles_about"];
    }

    public function fetchTitle($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);

        return $profileInfo[0]["profiles_introtitle"];
    }

    public function fetchText($user_id)
    {
        $profileInfo = $this->getProfileInfo($user_id);

        return $profileInfo[0]["profiles_introtext"];
    }


    public function fetchCategories($user_id)
    {
        $categories = $this->getCategories($user_id);

        return $categories;
    }

    public function fetchCurrentCategoryTopic($topic_id)
    {
        $categoryTopic = $this->getCurrentTopicCategory($topic_id);

        return $categoryTopic;
    }


    public function fetchTopics($user_id)
    {
        $topics = $this->getUserTopics($user_id);

        return $topics;
    }

    public function fetchPosts($user_id)
    {
        $posts = $this->getUserPosts($user_id);

        return $posts;
    }


    public function fetchCurrentPostTopic($post_id)
    {
        $postTopic = $this->getCurrentPostTopic($post_id);

        return $postTopic;
    }

    public function fetchProfilePicture($user_id)
    {
        $profilePicture = $this->getProfilePicture($user_id);
        // Output the profile picture path
        return $profilePicture;
    }
}
