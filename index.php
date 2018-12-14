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
// $consumer_key = urlencode('n3ST0sYNYBWGOozU28ZAEfubV');
// $consumer_secret = urlencode('COiVfWxwImk21ius062fA4FAmq1tmXmjGVVSJAxosHzjlkTkgY');
// $twitter = new TwitterClass($consumer_key, $consumer_secret);
// var_dump($twitter->posts);

// Instagram test
// $access_token = '9690936317.1677ed0.ca1cfbe8435a4e37b5acf365788878f0';
// $instagram = new InstagramClass($access_token);
// var_dump($instagram->posts);

// Constants test
// var_dump(TWITTER_API['consumer_key']);

// Social Media Posts Handler test
$handler = new SocialMediaPostsClass();
echo $handler->getPosts(array('twitter', 'instagram'));
