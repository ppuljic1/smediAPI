<?php

namespace Classes\API;


// Required files
require_once $_SERVER['DOCUMENT_ROOT'] .'/src/classes/API/SocialMediaAPIClass.php';

class FacebookAPIClass extends SocialMediaAPIClass
{
    private $access_token;
    private $group_id;

    function __construct() {
        
        $this->access_token = FACEBOOK_API['access_token'];
        $this->group_id = FACEBOOK_API['group_id'];

    }
    
    public function getPosts() {
        // Request URL
        $facebookURLPosts = "https://graph.facebook.com/$this->group_id/?fields=feed&access_token=$this->access_token";
        $apiResult = null;

        $curlCall = $this->curlExec($this->setOptArrayGetPosts($facebookURLPosts));
        if ( !$curlCall['success'] ) {
                
            // cURL call failed
            return $this->formatOutput(false, $curlCall['message']);

        } else {
            if ( !empty($postObject = json_decode($curlCall['value'])) ) {

                foreach( $postObject->feed->data as $post ) {

                    // Check if post has image
                    $postPhoto = $this->getPostPhoto($post->id);

                    // Check if post has message or story property
                    if ( isset($post->message) ) {
                        $message = $post->message;
                    } else if (  isset($post->story) ) {
                        $message = $post->story;
                    } else {
                        $message = "";
                    }

                    // Store results
                    $apiResult[] = array(
                        'type'          =>  'facebook',
                        'created_at'    =>  date('m/d/Y', strtotime($post->created_time)),
                        'text'          =>  $message,
                        'url'           =>  "https://www.facebook.com/$post->id",
                        'image'         =>  $postPhoto,
                    );

                }
                return $this->formatOutput(true, 'Posts successfully fetched!', $apiResult);
            } else {
                return $this->formatOutput(false, 'CURL Call completed successfully, empty result!');
            }
        }

    }

    private function setOptArrayGetPosts($facebookURL) {
        // CURL Request URL
        $request_url = $facebookURL;

        // Set cURL options array
        $optArray = array(
            CURLOPT_CUSTOMREQUEST   => "GET",
            CURLOPT_HEADER          => false,
            CURLOPT_POST            => false,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_URL             => $request_url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_FOLLOWLOCATION  => true, 
            CURLOPT_CONNECTTIMEOUT  => 120,
            CURLOPT_TIMEOUT         => 120,
            CURLOPT_USERAGENT       => $_SERVER['HTTP_USER_AGENT'],
            CURLOPT_MAXREDIRS       => 50,      
        );

        return $optArray;
    }

    /**
     * Check if facebook post has photo
     * Return photo url or empty string
     */
    private function getPostPhoto($postID) {
        // request url 
        $facebookURLPhoto = "https://graph.facebook.com/$postID?fields=full_picture&access_token=$this->access_token";

        $curlCall = $this->curlExec($this->setOptArrayGetPosts($facebookURLPhoto));
        if ( $curlCall['success'] ) { 
            if ( !empty($postPhoto = json_decode($curlCall['value'])) ) {
                if( isset($postPhoto->full_picture) ) {

                    return $postPhoto->full_picture;

                } else {
                    return '';
                }
            } else {
                return '';
            }
        } else {
            return '';
        }

    }


}