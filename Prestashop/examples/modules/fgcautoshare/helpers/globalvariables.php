<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $ChannelParams;
$ChannelParams = array('facebook' => array('title' => 'Facebook', 'key_params' => array('appId', 'secret', 'fb_id')),
    'twitter' => array('title' => 'Twitter', 'key_params' => array('consumer_key', 'consumer_secret', 'auth_token', 'auth_secret'))
    , 'linkedin' => array('title' => 'Linkedin', 'key_params' => array('li_api_key', 'li_api_secret', 'li_oauth_token', 'li_oauth_token_secret')),
    'google' => array('title' => 'Google+', 'key_params' => array('client_id', 'client_secret', 'redirect_uri', 'api_key')));

global $tbl_channels_field;
$tbl_channels_field = array('id', 'autoshare_channeltype_id', 'name', 'description', 'media_mode', 'status', 'error', 'order', 'params', 'published', 'auto_publish', 'created', 'created_by', 'modified', 'modified_by');
