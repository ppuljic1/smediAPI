<?php

// code .....

/**
 * api testing
 */
// require_once 'src/classes/API/TwitterAPIClass.php';
// require_once 'src/classes/API/InstagramAPIClass.php';
// use Classes\API\TwitterAPIClass;
// use Classes\API\InstagramAPIClass;

/**
 * social media objects testing
 */
// require_once 'src/classes/socialMedia/TwitterClass.php';
// require_once 'src/classes/socialMedia/InstagramClass.php';
// use Classes\SocialMedia\TwitterClass;
// use Classes\SocialMedia\InstagramClass;

/**
 * constants testing
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

// Social Media Posts Handler test
$handler = new SocialMediaPostsClass();
echo $handler->getPosts(array('twitter', 'instagram'));
