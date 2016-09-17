<?php

/**
 * @author Le Xuan Chien <chien.lexuan@gmail.com>
 */
include dirname(dirname(dirname(__FILE__))) . '/config/config.inc.php';
include dirname(dirname(dirname(__FILE__))) . '/init.php';
include dirname(__FILE__) . '/fgcautoshare.php';

$fgcautoshare = new fgcAutoshare();
//process for cronjob
if (isset($_REQUEST['secure_key'])) {
    $secureKey = Configuration::get('PS_FGCAUTOSHARE_SECURE_KEY');
    if (!empty($secureKey) AND $secureKey === $_REQUEST['secure_key']) {
        $fgcautoshare->processForCronjob();
    } else {
        file_put_contents(dirname(__FILE__) . '/log_access_cronjob.txt', date('Y-m-d H:i:s') . ': Error secure key' . "\n", FILE_APPEND);
        echo 'Error secure key';
    }
} else {
    echo 'Error secure key';
}