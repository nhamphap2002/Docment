<?php

/**
 * @author: Ho Ngoc Hang<kemly.vn@gmail.com>
 * @description:
 */
require_once("facebook-php-sdk/facebook.php");

class FgcFacebook {

    public static function getAccess($data_access = array()) {
        $fb = new Facebook($data_access);
        $access_token = $fb->getAccessToken();
        return $access_token;
    }
    
    /**
     * auto post to Facebook
     * @param type $data_access
     * ***********tham so chung thuc:
     * array(
            'appId' => FB_API_KEY, 
            'secret' => FB_SECRET,
            'fb_id' => FB_ID //facebook id
            )
     * @param type $content
     * ***********Tham so noi dung post:
     * array(
            "message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
            "link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
            "picture" => "http://i.imgur.com/lHkOsiH.png",
            "name" => "How to Auto Post on Facebook with PHP",
            "caption" => "www.pontikis.net",
            "description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation."
          )
     */
    public function autoPost($data_access = array(), $content = array()) {
        $data_access['fileUpload'] = false;
        $facebook = new Facebook($data_access);
        $access_token = $facebook->getAccessToken();
        //post to facebook
        $facebook->setAccessToken($access_token);
        $fb_id = $data_access['fb_id'];
        try {
            $facebook->api('/'.$fb_id.'/feed', 'POST', $content);
            $result = 'ok';
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

}

?>