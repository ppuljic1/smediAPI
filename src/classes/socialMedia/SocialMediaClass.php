<?php

namespace Classes\SocialMedia;

abstract class SocialMediaClass
{
    private $status;
    private $message;
    private $posts;

    function __construct() {
        
    }

    // GETTER
    public function __get($property) {  
        if (property_exists($this, $property)) {  
            return $this->$property;  
        }  
    }  

}
