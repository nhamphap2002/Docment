<?php

include dirname(dirname(dirname(__FILE__))) . '/config/config.inc.php';
include dirname(dirname(dirname(__FILE__))) . '/init.php';
include dirname(__FILE__) . '/evaluationasking.php';

$evaluationAsking = new evaluationAsking();
if (isset($_REQUEST['secure_key']) && isset($_REQUEST['date_time']) && isset($_REQUEST['type'])) {
    $secureKey = Configuration::get('PS_EVALUATIONASKING_SECURE_KEY');
    if (!empty($secureKey) AND $secureKey === $_REQUEST['secure_key']) {
        $date_time = $_REQUEST['date_time'];
        $type = $_REQUEST['type'];
        $evaluationAsking->processSendEmail($date_time, $type);
    }
}