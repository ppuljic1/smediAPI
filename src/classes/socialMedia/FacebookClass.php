<?php 

namespace Classes\SocialMedia;

require_once 'src/classes/API/FacebookAPIClass.php';

use Classes\API\FacebookAPIClass;


class FacebookClass extends SocialMediaClass
{
    function __construct() {
        // $instagramObj = new InstagramAPIClass();
        // $instagramObj = json_decode($instagramObj->getPosts());

        $this->status = true;
        $this->message = "Placeholder data, facebook posts";
        $this->posts = json_decode('[{"type":"facebook","created_at":"14/02/2018","text":"\u0627\u0644\u0631\u0627\u0628\u0637 \u0627\u0644\u0639\u062c\u064a\u0628 \u0628\u064a\u0646 \u0645\u0623\u0633\u0627\u0629 \u0645\u062f\u0646\u0646\u0627 \u0648\u0639\u0627\u0644\u0645 \u0627\u0644\u0646\u0641\u0633 \u0623\u0628\u0631\u0627\u0647\u0627\u0645 \u0645\u0627\u0633\u0644\u0648 - \u062b\u0645\u0627\u0646\u064a\u0629: http:\/\/www.thmanyah.loc\/colony\/the-city-and-abraham-maslow","url":"https:\/\/facebook.com\/statuses\/1072814865084018689", "image":""},{"type":"facebook","created_at":"11/02/2018","text":"I need me a second tweet to see how diz biz workzzZZzzzz","url":"https:\/\/facebook.com\/statuses\/1069505520581644288", "image":""},{"type":"facebook","created_at":"10/02/2018","text":"This facebook account is exclusively for API testing purposes so... Good morning world, and in case I dont see ya, good afternoon, good evening, and good night! \n#test123#firstTweet https:\/\/t.co\/1xd4qWq9oQ","url":"https:\/\/facebook.com\/statuses\/1069349003354144770", "image":""}]');
        
    }
}