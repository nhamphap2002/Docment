<?php

include dirname(dirname(dirname(__FILE__))) . '/config/config.inc.php';
include dirname(dirname(dirname(__FILE__))) . '/init.php';
include dirname(__FILE__) . '/belvg_popupcart.php';

$popup = new belvg_popupcart();
if ($_REQUEST['ajax'] && $_REQUEST['type'] == 'check_accessories') {
    echo $popup->checkAccessories();
} elseif ($_REQUEST['ajax'] && $_REQUEST['type'] == 'process_popup') {
    echo $popup->processDataForPopup(null);
}

exit();
?>