<?php

class SocialMediaClass
{
    private $socialMediaPosts = array();

    function __construct() {
        
    }

    public function getPosts() {
        return json_encode($this->socialMediaPosts);
    }

}
