<?php

header('Content-Type: text/html');


/**
 * API TESTING
 */
// require_once 'src/classes/API/FacebookAPIClass.php';
// require_once 'src/classes/API/TwitterAPIClass.php';
// require_once 'src/classes/API/InstagramAPIClass.php';
// use Classes\API\FacebookAPIClass;
// use Classes\API\TwitterAPIClass;
// use Classes\API\InstagramAPIClass;

/**
 * SOCIAL MEDIA OBJECTS TESTING
 */
// require_once 'src/classes/socialMedia/FacebookClass.php';
// require_once 'src/classes/socialMedia/TwitterClass.php';
// require_once 'src/classes/socialMedia/InstagramClass.php';
// use Classes\SocialMedia\FacebookClass;
// use Classes\SocialMedia\TwitterClass;
// use Classes\SocialMedia\InstagramClass;

/**
 * CONSTANTS TESTING
 */
// require_once $_SERVER['DOCUMENT_ROOT'] .'/src/settings/defineKeys.php';
// use Settings\DefineKeys;

/**
 * Social Media Posts Handler testing
 */
require_once 'src/classes/handler/SocialMediaPostsClass.php';
use Classes\Handler\SocialMediaPostsClass;



// Twitter test
// $twitter = new TwitterAPIClass();
// var_dump(json_decode($twitter->getPosts()));

// Instagram test
// $instagram = new InstagramAPIClass();
// var_dump(json_decode($instagram->getPosts()));

// Constants test
// var_dump(TWITTER_API['consumer_key']);

// Facebook testing
// $facebook = new FacebookAPIClass();
// var_dump(json_decode($facebook->getPosts()));

// Social Media Posts Handler test
$handler = new SocialMediaPostsClass();
echo $handler->getPosts(array('twitter', 'instagram', 'facebook'));
