<?php


class ProfileInfoContr extends ProfileInfo
{
    private $user_id;
    private $username;

    public function __construct($user_id, $username)
    {
        $this->user_id = $user_id;
        $this->username =  $username;
    }

    public function defaultProfileInfo()
    {
        $profileAbout = "Introduce your self here! whatever floats your boat";
        $profileTitle = "Hi! I am " . $this->username;

        $defaultImages = [
            "../img/default_imgs/dog.jpg",
            "../img/default_imgs/cat_bento.png",
            "../img/default_imgs/default_bento_2.png"
        ];
        $randomPfp = array_rand($defaultImages);

        $default_pfp = $defaultImages[$randomPfp];

        $profileText = "Welcome to my corner of the web. Take a look around and make yourself comfortable.";
        $this->setProfileInfo($profileAbout, $profileTitle, $profileText, $this->user_id);
        $this->updateProfilePfp($default_pfp, $this->user_id);
    }

    public function updateProfileInfo($about, $introTitle, $introText)
    {
        if ($this->emptyInputCheck($about, $introTitle, $introText) == true) {
            header("location: ../user/profile_settings.php?error=emptyinput");
            exit();
        }

        //update info
        $this->_updateProfileInfo($about, $introTitle, $introText, $this->user_id);
    }

    private function emptyInputCheck($about, $introTitle, $introText)
    {

        $result = false;

        if (empty($about) || empty($introTitle) || empty($introText)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}
