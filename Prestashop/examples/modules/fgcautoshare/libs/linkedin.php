<?php

/**
 * @author: Ho Ngoc Hang<kemly.vn@gmail.com>
 * @description:
 */
include 'LinkedIn/linkedin_3.2.0.class.php';

class FgcLinkedin {

    /**
     * authen account to Linkedin
     * @param type $data_access
     * @return \SimpleLinkedIn\LinkedIn
     */
    public static function getAccess($data_access) {
        $API_CONFIG = array(
            'appKey' => $data_access['li_api_key'],
            'appSecret' => $data_access['li_api_secret'],
            'callbackUrl' => null
        );

        $app = new SimpleLinkedIn\LinkedIn($API_CONFIG);

        $ACCESS_TOKEN = array(
            'oauth_token' => $data_access['li_oauth_token'],
            'oauth_token_secret' => $data_access['li_oauth_token_secret']
        );
        $app->setTokenAccess($ACCESS_TOKEN);
        return $app;
    }

    /**
     * getUser.
     *
     * @return	object
     */
    public function checkOAuth($data_access) {
        if (empty($data_access['li_api_key']) || empty($data_access['li_api_secret']) || empty($data_access['li_oauth_token']) || empty($data_access['li_oauth_token_secret'])) {
            return array(false, 'Access Token and/or Token secret not entered (getUser).');
        }

        $result = null;

        try {
            $api = self::getAccess($data_access);
            $response = $api->profile('~:(id,first-name,last-name,headline,public-profile-url)');

            if ($response['success'] === true) {
                $xml = $response['linkedin'];
                $user = simplexml_load_string($xml);
                $user = json_decode(json_encode($user));
                $url = $user->{'public-profile-url'};

                $result = array(
                    'status' => 'verified',
                    'error_message' => 'Verified',
                    'user' => $user,
                    'url' => $url
                );
            } else {
                $msg = $response['info']['http_code'];
                $result = array(
                    'status' => 'not_verified',
                    'error_message' => $msg
                );
            }
        } catch (LinkedInException $e) {
            $result = array(
                'status' => 'not_verified',
                'error_message' => $e->getMessage()
            );
        }

        return $result;
    }

    /**
     * auto post to Linkedin
     * @param type $data_access
     * ***********tham so chung thuc:
     * array(
      'api_key'=> LI_API_KEY,
      'api_secret'=> LI_API_SECRET,
      'oauth_token'=> LI_OAUTH_TOKEN,
      'oauth_token_secret'=> LI_OAUTH_TOKEN_SECRET,
      )
     * @param type $content
     * ***********Tham so noi dung post:
     * array('comment' => 'day la comment', 
      'title' => 'day la title',
      'submitted-url' => 'xxx',
      'submitted-image-url' => 'https://www.google.com.vn/logos/doodles/2014/world-cup-2014-34-6330075825831936-hp.gif',
      'description' => 'day la mo ta')
     */
    public function autoPost($data_access = array(), $content = array()) {
        $app = self::getAccess($data_access);
        $response = $app->share('new', $content, FALSE);
        if ($response['success'] === true) {
            $result = 'ok';
        } else {
            $result = $response['error'];
        }
        return $result;
    }

}

?>