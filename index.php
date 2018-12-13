<?php

// code .....

require 'src/classes/APIs/TwitterAPIClass.php';

use Classes\API\TwitterAPIClass;

$consumer_key = urlencode('n3ST0sYNYBWGOozU28ZAEfubV');
$consumer_secret = urlencode('COiVfWxwImk21ius062fA4FAmq1tmXmjGVVSJAxosHzjlkTkgY');

$x = new TwitterAPIClass($consumer_key, $consumer_secret);

$x = $x->getTweets();
// var_dump($x);
$x = json_decode($x);
var_dump($x->value);
