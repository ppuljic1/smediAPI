<?php

// code ....
// echo 'Lets dance';

/**
 * TWITTER
 **/
$consumer_key = urlencode('n3ST0sYNYBWGOozU28ZAEfubV');
$consumer_secret = urlencode('COiVfWxwImk21ius062fA4FAmq1tmXmjGVVSJAxosHzjlkTkgY');
$bearer_token = $consumer_key . ':' . $consumer_secret;
$encoded_bearer_token = base64_encode($bearer_token);

// Output variable
$appTweets = null;

// Get cURL resource
$curl = curl_init();

// Set cURL headers
$headers = array(
    "POST /oauth2/token HTTP/1.1",
    "Host: api.twitter.com",
    "User-Agent: ppuljic twitter Application-only OAuth App v.1",
    "Authorization: Basic " . $encoded_bearer_token,
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

// Execute cURL
if (!$result = curl_exec($curl)) {

    // cURL call failed, do something .....
    echo 'cURL error string: "' . curl_error($curl) . '" <br> cURL error number: ' . curl_errno($curl);
    // Close cURL
    curl_close($curl);

} else {

    // cURL call was successfull, do something ....

    // Check that value associated with the token_type key of the returned object is bearer
    if (!empty($resultJSON = json_decode($result))) {
        if ($resultJSON->token_type == 'bearer') {

            // Close cURL
            curl_close($curl);

            // GET USER TWEETS
            // Get cURL resource
            $curl = curl_init();

            // Set cURL headers
            $headers = array(
                "GET /1.1/statuses/user_timeline.json?screen_name=TTestbeast HTTP/1.1",
                "Host: api.twitter.com",
                "User-Agent: ppuljic twitter Application-only OAuth App v.1",
                "Authorization: Bearer " . $resultJSON->access_token,
                "Content-Type: application/json",
                // "Accept-Encoding: gzip"
            );

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
                echo 'cURL error string: "' . curl_error($curl) . '" <br> cURL error number: ' . curl_errno($curl);
                // Close cURL
                curl_close($curl);
            } else {
                if (!empty($tweets = json_decode($result))) {
                    // Tweets fetched successfully, do something.....
                    foreach ($tweets as $tweet) {
                        $tweetURL = "https://twitter.com/statuses/$tweet->id_str";

                        $appTweets[] = array(
                            'type' => 'twitter',
                            'created_at' => $tweet->created_at,
                            'text' => $tweet->full_text,
                            'url' => $tweetURL,
                        );
                    }
                    // Close cURL
                    curl_close($curl);
                }
            }

        } else { // Not bearer token type
        }
    } else { // Result is not JSON do something .....

    }
}

// TON
// var_dump($appTweets);

/**
 * INSTAGRAM
 **/
$access_token = '9690936317.1677ed0.ca1cfbe8435a4e37b5acf365788878f0';
$client_id = '948e658b019f46ea877f6d4d39a548ac';
$request_url = "https://api.instagram.com/v1/users/self/media/recent/?access_token=$access_token";

// GET INSTAGRAM CONTENT
// Get cURL resource
$curl = curl_init();

// Set cURL headers
$headers = array(
    "GET /v1/users/self/media/recent HTTP/1.1",
    "Host: api.instagram.com",
    "User-Agent: ppuljic instagram Application-only OAuth App v.1",
    "Content-Type: application/json",
);

// Set cURL options array
curl_setopt_array($curl, array(
    CURLOPT_URL => $request_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => $headers,
));

if (!$result = curl_exec($curl)) {
    // Failed fetching tweets, do something .....
    echo 'cURL error string: "' . curl_error($curl) . '" <br> cURL error number: ' . curl_errno($curl);
    // Close cURL
    curl_close($curl);

} else {
    if (!empty($posts = json_decode($result))) {
        // Tweets fetched successfully, do something.....
        // var_dump($posts->data);
        foreach ($posts->data as $post) {
            // echo "Image: " . $post->images->standard_resolution->url . '<br>';
            if (!empty($post->caption)) {
                $postText = $post->caption->text;
            } else {
                $postText = '';
            }

            $appInstaPosts[] = array(
                'type' => 'instagram',
                'created_at' => date('m/d/Y', $post->created_time),
                'text' => $postText,
                'url' => $post->link,
            );

        }
        // Close cURL
        curl_close($curl);
    }
    // Empty result do something....
}

var_dump($appInstaPosts);

//type
//created_at
//text
//url

/**
 * FACEBOOK
 **/
// Get cURL resource
$curl = curl_init();

// Set cURL headers
$headers = array(
    "GET /oauth/access_token HTTP/1.1",
    "Host: graph.facebook.com",
    "User-Agent: ppuljic facebook Application-only OAuth App v.1",
);

// Set cURL options array
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://graph.facebook.com/oauth/access_token?client_id=259962121350259&client_secret=984f9ba84ea9f64d44b442afc6aff320&grant_type=client_credentials',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => $headers,
));

// Execute cURL
if (!$result = curl_exec($curl)) {
    echo 1;
    curl_close($curl);
} else {
    // var_dump($result);
    curl_close($curl);
}

// echo '<br>'.$_SERVER['SERVER_NAME'];
