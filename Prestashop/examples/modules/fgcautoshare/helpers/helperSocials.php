<?php

/**
 * @author: Ho Ngoc Hang<kemly.vn@gmail.com>
 * @description:
 */
require_once dirname(dirname(__FILE__)) . "/libs/facebook.php";
require_once dirname(dirname(__FILE__)) . "/libs/linkedin.php";
require_once dirname(dirname(__FILE__)) . "/libs/twitter.php";

class FGCAutoshareHelperSocials {

    public function postToSocials($type, $data_access, $content) {
        switch ($type) {
            case 'facebook':
                $app = new FgcFacebook();
                break;
            case 'linkedin':
                $app = new FgcLinkedin();
                break;
            case 'twitter':
                $app = new FgcTwitter();
                break;
            default:
                $app = new stdClass();
                break;
        }
        $response_error = $app->autoPost($data_access, $content);
        if ($response_error != 'ok') {
            return $response_error;
        } else {
            return 'ok';
        }
    }

    public function oAuthen($type, $data_access) {
        switch ($type) {
            case 'facebook':
                $app = new FgcFacebook();
                break;
            case 'linkedin':
                $app = new FgcLinkedin();
                break;
            case 'twitter':
                $app = new FgcTwitter();
                break;
            default:
                $app = new stdClass();
                break;
        }
       
        $response = $app->checkOAuth($data_access);
        return $response;
    }

}
