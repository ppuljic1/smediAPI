<?php

namespace Classes\API;

// Required files
require_once $_SERVER['DOCUMENT_ROOT'] .'/src/classes/API/SocialMediaAPIClass.php';

class InstagramAPIClass extends SocialMediaAPIClass
{

    // GET INSTAGRAM POSTS
    public function getPosts() {
        // Return value
        $apiResult = null;
        
        $curlCall = $this->curlExec($this->setOptArrayGetPosts(INSTAGRAM_API['access_token']));

        if ( !$curlCall['success'] ) {
            
            // cURL call failed
            return $this->formatOutput(false, $curlCall['message']);

        } else {
            if ( !empty($posts = json_decode($curlCall['value'])) ) {

                foreach ($posts->data as $post) {
                    // Check if post has caption text
                    if (!empty($post->caption)) {
                        $postText = $post->caption->text;
                    } else {
                        $postText = '';
                    }

                    // Store results
                    $apiResult[] = array(
                        'type'          =>  'instagram',
                        'created_at'    =>  date('m/d/Y', $post->created_time),
                        'text'          =>  $postText,
                        'url'           =>  $post->link,
                        'image'         =>  $post->images->standard_resolution->url,
                    );
                }
                return $this->formatOutput(true, 'Instagram posts successfully fetched!', $apiResult);

            } else {

                return $this->formatOutput(false, 'CURL Call completed successfully, empty result!');
                
            }
        }
    }


    private function setOptArrayGetPosts($access_token) {
        // CURL Request URL
        $request_url = "https://api.instagram.com/v1/users/self/media/recent/?access_token=$access_token";

        // Set cURL headers
        $headers = array(
            "GET /v1/users/self/media/recent HTTP/1.1",
            "Host: api.instagram.com",
            "User-Agent: ppuljic instagram Application-only OAuth App v.1",
            "Content-Type: application/json",
        );

        

        // Set cURL options array
        $optArray = array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => $headers,
        );

        return $optArray;
    }
}
