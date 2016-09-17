<?php

/**
 * @author: Ho Ngoc Hang<kemly.vn@gmail.com>
 * @description:
 */
include 'twitteroauth/twitteroauth.php';

class FgcTwitter {

    public static function getAccess($data_access = array()) {
        $connection = new TwitterOAuth($data_access['consumer_key'], $data_access['consumer_secret'], $data_access['auth_token'], $data_access['auth_secret']);
        return $connection;
    }
    
    public function checkOauth($data_access){
        $twitteroauth = self::getAccess($data_access);
        print_r($twitteroauth);exit();
        if($twitteroauth->http_code==200){
             $result = array(
                    'status' => 'verified',
                    'error_message' => 'Verified'
                );
        }else{
            $result = array(
                    'status' => 'not_verified',
                    'error_message' => 'Not Verified'
                );
        }
        return $result;
    }

    public function verify($data_access = array()) {
        $api = self::getAccess($data_access);
        $code = $api->request('GET', $api->url('1.1/account/verify_credentials'));
        $response = TwitterChannelHelper::_processResponse($code, $api);

        if ($response[0]) {
            // Process response-headers
            $result = self::processHeaders($code, $api);

            $user = $result[2];
            $url = 'https://twitter.com/' . $user->screen_name;

            $message = array(
                'status' => true,
                'error_message' => $result[1],
                'user' => $user,
                'url' => $url
            );

            return $message;
        }

        $message = array(
            'status' => false,
            'error_message' => $response[1]
        );

        return $message;
    }

    public static function processHeaders($code, &$api) {
        $msg = $code . ' - ' . JText::_('COM_AUTOTWEET_HTTP_ERR_' . $code);

        if (array_key_exists('headers', $api->response)) {
            $headers = $api->response['headers'];

            if (array_key_exists('x-access-level', $headers)) {
                $accesslevel = $headers['x-access-level'];
            } elseif (array_key_exists('X-Access-Level', $headers)) {
                $accesslevel = $headers['X-Access-Level'];
            } else {
                $accesslevel = 'Not detected';
            }

            $msg = $msg . ' (access level: ' . $accesslevel . ')';

            // Show rates
            if (($accesslevel == 'read-write') || ($accesslevel == 'read-write-directmessages')) {
                $msg = $msg . ' (rate limit: ' . $headers['x-rate-limit-remaining'] . '/' . $headers['x-rate-limit-limit'] . ')';
                $response = json_decode($api->response['response']);

                return array(true,$msg,$response);
            } else {
                return array(false,$msg);
            }
        }

        return array(false,$msg);
    }

    /**
     * auto post to Twitter
     * @param type $data_access
     * ***********tham so chung thuc:
     * array(
      'cons_key'=> CONSUMER_KEY,
      'cons_secret'=> CONSUMER_SECRET,
      'oauth_token'=> AUTH_TOKEN,
      'oauth_token_secret'=> AUTH_SECRET,
      )
     * @param type $content
     * ***********Tham so noi dung post:
     * array(
      'status' => 'Test post to Twitter'
      )
     */
    public function autoPost($data_access, $content) {
        $connection = self::getAccess($data_access);
        $status = $connection->post('statuses/update', $content);
        if (isset($status->errors)) {
            $result = 'error ' . $status->errors[0]->code . ': ' . $status->errors[0]->message;
        } else {
            $result = 'ok';
        }
        return $result;
    }

}

?>