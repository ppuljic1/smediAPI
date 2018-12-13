<?php

namespace Classes\API;

// Required files
require $_SERVER['DOCUMENT_ROOT'] .'/src/interfaces/APIInterface.php';
require $_SERVER['DOCUMENT_ROOT'] .'/src/traits/apiCalls.php';
require $_SERVER['DOCUMENT_ROOT'] .'/src/traits/outputHandler.php';

use Interfaces\API\APIInterface as API;
use Traits\APICalls;
use Traits\OutputHandler;

/**
 * Link to full documentation, REFACTOR
 * Key : TWITTER_R
 */
class TwitterAPIClass implements API
{
    use APICalls, OutputHandler;

    private $encoded_bearer_token;

    function __construct($consumer_key, $consumer_secret) {
 
        // TWITTER_R 
        $bearer_token = $consumer_key . ':' . $consumer_secret;
        $this->encoded_bearer_token = base64_encode($bearer_token);

    }

    // Get API Bearer Token
    private function getAPIBarrerToken() {
        // Get cURL resource
        $curl = curl_init();

        // Set cURL headers
        $headers = array(
            "POST /oauth2/token HTTP/1.1",
            "Host: api.twitter.com",
            "User-Agent: ppuljic twitter Application-only OAuth App v.1",
            "Authorization: Basic " . $this->encoded_bearer_token,
            "Content-Type: application/x-www-form-urlencoded;charset=UTF-8",
        );

        // Set cURL options array
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.twitter.com/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
        ));

        if (!$result = curl_exec($curl)) {
            // Close cURL
            curl_close($curl);
            // cURL call failed, do something .....
            $message = 'cURL error string: "' . curl_error($curl) . '" <br> cURL error number: ' . curl_errno($curl);
            return $this->formatOutput(false, $message);
        } else {
            // Close cURL
            curl_close($curl);
            if (!empty($resultJSON = json_decode($result))) {
                if ($resultJSON->token_type == 'bearer') {
                    $message = 'API Barrer token successfully fetched!';
                    return $this->formatOutput(true, $message, $resultJSON->access_token);
                } else {
                    $message = 'Request passed, but did not recive barrer token type!';
                    return $this->formatOutput(false, $message);
                }
            } else {
                $message = 'Request passed, but empty result returned!';
                return $this->formatOutput(false, $message);
            }
        }


    }

    public function getTweets() {
        // Return value
        $apiResult = null;
        $accessToken = $this->getAPIBarrerToken();

        if( $this->readOutput('status', $accessToken) ) {

            // GET USER TWEETS
            // Get cURL resource
            $curl = curl_init();

            // Set cURL headers
            $headers = array(
                "GET /1.1/statuses/user_timeline.json?screen_name=TTestbeast HTTP/1.1",
                "Host: api.twitter.com",
                "User-Agent: ppuljic twitter Application-only OAuth App v.1",
                "Authorization: Bearer " . $this->readOutput('value', $accessToken),
                "Content-Type: application/json"
            );

            $accessToken = null;

            // Set cURL options array
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=TTestbeast&tweet_mode=extended',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTPHEADER => $headers,
            ));
    
            if (!$result = curl_exec($curl)) {
                // Failed fetching tweets, do something .....
                $message = 'cURL error string: "' . curl_error($curl) . '" <br> cURL error number: ' . curl_errno($curl);
                // Close cURL
                curl_close($curl);
                return $this->formatOutput(false, $message);

            } else {
                if (!empty($tweets = json_decode($result))) {
                    // Tweets fetched successfully, do something.....
                    foreach ($tweets as $tweet) {
                        $tweetURL = "https://twitter.com/statuses/$tweet->id_str";
    
                        $value[] = array(
                            'type' => 'twitter',
                            'created_at' => $tweet->created_at,
                            'text' => $tweet->full_text,
                            'url' => $tweetURL,
                        );
                    }
                    // Close cURL
                    curl_close($curl);
                    $message = 'Tweets successfully fetched!';
                    return $this->formatOutput(true, $message, $value);
                }
            }

        } else {
            // Failed getting API Barrer Token
            $message = 'Failed getting API Barrer Token';
            return $this->formatOutput(false, $message);
        }


    }
    

}

