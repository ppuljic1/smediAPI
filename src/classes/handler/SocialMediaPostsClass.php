<?php

namespace Classes\Handler;


require_once $_SERVER['DOCUMENT_ROOT'] .  '/src/classes/socialMedia/InstagramClass.php';
require_once $_SERVER['DOCUMENT_ROOT'] .  '/src/classes/socialMedia/TwitterClass.php';
require_once $_SERVER['DOCUMENT_ROOT'] .  '/src/classes/socialMedia/FacebookClass.php';
require_once $_SERVER['DOCUMENT_ROOT'] .  '/src/traits/outputHandler.php';

use Classes\SocialMedia\InstagramClass;
use Classes\SocialMedia\TwitterClass;
use Classes\SocialMedia\FacebookClass;
use Traits\OutputHandler;

class SocialMediaPostsClass {

    use OutputHandler;
    
    private $twitter;// = new TwitterClass();
    private $instagram;// = new InstagramClass();
    private $facebook;

    function __construct() {
        $this->twitter = new TwitterClass();
        $this->instagram = new InstagramClass();
        $this->facebook = new FacebookClass();
    }

    // GETTERS 
    public function getPosts( $socialMediaArray, $order=null, $orderCreated=null ) {
        
        // Check if correct value was passed
        if( is_array($socialMediaArray) ) {
            if( !(in_array('facebook', $socialMediaArray ) || in_array('twitter', $socialMediaArray )  || in_array('instagram', $socialMediaArray ))  ) {
                return $this->formatOutput(false, 'Wrong socialMediaArray value passed, only: "facebook", "instagram", "twitter" values are valid input');
            }
        } else {
            return $this->formatOutput(false, 'socialMediaArray variable has to be array');
        }

        // Get posts
        if( empty($order) && empty($orderCreated) ) { // Samo sm

            if( count($socialMediaArray) == 1 ) {

                return $this->formatOutput(true, '', $this->$socialMediaArray[0]->posts);

            } else {

                $output = array();
                foreach( $socialMediaArray as $socialMedia ) {
                    $output = array_merge($output, $this->$socialMedia->posts); 
                } 
                usort($output, function($a, $b) {
                    return ($a->created_at>$b->created_at);
                });
                return $this->formatOutput(true, '', $output);
                
            }

        } else if( !empty($order) && empty($orderCreated) ) {// sm sa order

        } else if( !empty($order) && !empty($orderCreated) ) {// sm sa order i sa orderCreated

        }

    }

    static function cmp($a, $b) {
        if( strtotime($a->created_at) == strtotime($b->created_at) ) {
            return 0;
        } else {
            return (strtotime($a->created_at) < strtotime($b->created_at)) ? 1 : -1;
        } 
    }
    
    
}

