<?php 

namespace Classes\SocialMedia;

require_once 'src/classes/API/FacebookAPIClass.php'; 

use Classes\API\FacebookAPIClass;


class FacebookClass extends SocialMediaClass
{
    function __construct() {
        $facebookObj = new FacebookAPIClass();
        $facebookObj = json_decode($facebookObj->getPosts());

        $this->status = $facebookObj->status;
        $this->message = $facebookObj->message;
        $this->posts = $facebookObj->value;
        
    }
}