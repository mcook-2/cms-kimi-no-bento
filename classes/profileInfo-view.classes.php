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
}
