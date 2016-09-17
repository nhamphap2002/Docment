<?php

include dirname(dirname(dirname(__FILE__))) . '/config/config.inc.php';
include dirname(dirname(dirname(__FILE__))) . '/init.php';
include dirname(__FILE__) . '/popupaddtocart.php';
$popup = new popupAddtocart();

$query = Tools::getValue('q', false);

if ($pos = strpos($query, ' (ref:'))
    $query = substr($query, 0, $pos);

$excludeIds = Tools::getValue('excludeIds', false);
if ($excludeIds && $excludeIds != 'NaN')
    $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
else
    $excludeIds = '';

// Excluding downloadable products from packs because download from pack is not supported
$excludeVirtuals = (bool) Tools::getValue('excludeVirtuals', false);
$exclude_packs = (bool) Tools::getValue('exclude_packs', false);
$p = $popup->searchProducts($query, $excludeIds, $excludeVirtuals, $exclude_packs);
var_dump($p);
exit();
