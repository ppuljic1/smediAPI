<?php

namespace Classes\SocialMedia;

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/classes/API/TwitterAPIClass.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/classes/socialMedia/SocialMediaClass.php';

use Classes\API\TwitterAPIClass;

class TwitterClass extends SocialMediaClass
{
    function __construct() {
        $twitterObj = new TwitterAPIClass();
        $twitterObj = json_decode($twitterObj->getPosts());

        $this->status = $twitterObj->status;
        $this->message = $twitterObj->message;
        $this->posts = $twitterObj->value;
        
    }
}
