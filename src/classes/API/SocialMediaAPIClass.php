<?php

namespace Classes\API;

// Required files
require_once $_SERVER['DOCUMENT_ROOT'] .'/src/traits/apiCalls.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/src/traits/outputHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/src/settings/defineKeys.php';

use Settings\DefineKeys;
use Traits\APICalls;
use Traits\OutputHandler;

abstract class SocialMediaAPIClass 
{
    use APICalls, OutputHandler;

    public function getPosts() {
        
    }
}
