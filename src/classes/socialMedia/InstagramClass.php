<?php

namespace Classes\SocialMedia;

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/classes/API/InstagramAPIClass.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/classes/socialMedia/SocialMediaClass.php';

use Classes\API\InstagramAPIClass;

class InstagramClass extends SocialMediaClass 
{
    function __construct() {
        $instagramObj = new InstagramAPIClass();
        $instagramObj = json_decode($instagramObj->getPosts());

        $this->status = $instagramObj->status;
        $this->message = $instagramObj->message;
        $this->posts = $instagramObj->value;
        
    }
}