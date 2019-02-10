<?php

namespace Classes\API;

// Required files
require_once $_SERVER['DOCUMENT_ROOT'] .'/src/classes/API/SocialMediaAPIClass.php';

class TwitterAPIClass extends SocialMediaAPIClass
{
    private $encoded_bearer_token;

    function __construct() {

        $bearer_token = TWITTER_API['consumer_key'] . ':' . TWITTER_API['consumer_secret'];
        $this->encoded_bearer_token = base64_encode($bearer_token);

    }

    // GET API BARRER TOKEN
    private function getAPIBarrerToken() {
        // Set curl headers and options array 
        // Execute curl
        $curlCall = $this->curlExec($this->setOptArrayApiBarrerToken());
        $this->encoded_bearer_token = null;
        
        if ( !$curlCall['success'] ) {

            // cURL call failed
            return $this->formatOutput(false, $curlCall['message']);

        } else {
            // Handel curl results
            if ( !empty($resultJSON = json_decode($curlCall['value'])) ) {

                if ($resultJSON->token_type == 'bearer') { // SUCCESS -> API Barrer token fetched
                    return $this->formatOutput(true, 'API Barrer token successfully fetched!', $resultJSON->access_token);
                } else { // FAIL -> did not recive barrer token type
                    return $this->formatOutput(false, 'Request passed, but did not recive barrer token type!');
                }

            } else { // FAIL -> empty result returned
                return $this->formatOutput(false, 'Request passed, but empty result returned!');
            }

        }
    }

    public function getPosts() {
        // Return value
        $apiResult = null;
        $accessToken = $this->getAPIBarrerToken();

        if( $this->readOutput('status', $accessToken) ) {

            $curlCall = $this->curlExec($this->setOptArrayGetPosts($accessToken));

            if ( !$curlCall['success'] ) {
                
                // cURL call failed
                return $this->formatOutput(false, $curlCall['message']);

            } else {
                if ( !empty($tweets = json_decode($curlCall['value'])) ) {

                    // Tweets fetched successfully
                    foreach ($tweets as $tweet) {
                        $tweetURL = "https://twitter.com/statuses/$tweet->id_str";

                        // Check if tweet has an image
                        // Note to self: put in separate function, in parent, every api class should have hasImage() methode
                        $tweetImage = '';
                        if( property_exists($tweet->entities, 'media') ) {
                            $tweetImage = $tweet->entities->media[0]->media_url;
                        }

                        // Store results
                        $apiResult[] = array(
                            'type'          =>  'twitter',
                            'created_at'    =>  date('m/d/Y', strtotime($tweet->created_at)),
                            'text'          =>  $tweet->full_text,
                            'url'           =>  $tweetURL,
                            'image'         =>  $tweetImage,
                        );
                    }
                    return $this->formatOutput(true, 'Tweets successfully fetched!', $apiResult);

                } else {

                    return $this->formatOutput(false, 'CURL Call completed successfully, empty result!');

                }
            }
        } else {
            // Failed getting API Barrer Token
            return $this->formatOutput(false, 'Failed getting API Barrer Token');
        }


    }

    private function setOptArrayApiBarrerToken() {
        // Set cURL headers
        $headers = array(
            "POST /oauth2/token HTTP/1.1",
            "Host: api.twitter.com",
            "User-Agent: ppuljic twitter Application-only OAuth App v.1",
            "Authorization: Basic " . $this->encoded_bearer_token,
            "Content-Type: application/x-www-form-urlencoded;charset=UTF-8",
        );
        // Set cURL options array
        $optArray = array(
            CURLOPT_URL => 'https://api.twitter.com/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
        );

        return $optArray;
    }

    private function setOptArrayGetPosts($accessToken) {
        // CURL Request URL
        $request_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=TTestbeast&tweet_mode=extended';

        // Set cURL headers
        $headers = array(
            "GET /1.1/statuses/user_timeline.json?screen_name=TTestbeast HTTP/1.1",
            "Host: api.twitter.com",
            "User-Agent: ppuljic twitter Application-only OAuth App v.1",
            "Authorization: Bearer " . $this->readOutput('value', $accessToken),
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

    private function setOptArrayTwitterScrap($twitterURL) {
        // CURL Request URL
        $request_url = $twitterURL;

        // Set cURL headers
        $headers = array(
            "GET /1.1/statuses/user_timeline.json?screen_name=TTestbeast HTTP/1.1",
            "Host: api.twitter.com",
            "User-Agent: ppuljic twitter Application-only OAuth App v.1",
            "Authorization: Bearer " . $this->readOutput('value', $accessToken),
            "Content-Type: application/json",
        );

        // Set cURL options array
        $optArray = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",
            CURLOPT_HEADER         => false,
            CURLOPT_POST           =>false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true, 
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_USERAGENT      =>$_SERVER['HTTP_USER_AGENT'],
            CURLOPT_MAXREDIRS      => 50,       
            CURLOPT_HTTPHEADER => $headers,
        );

        return $optArray;
    }

}
