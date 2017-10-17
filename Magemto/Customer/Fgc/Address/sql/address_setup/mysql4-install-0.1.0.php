<?php

$installer = $this;

$installer->startSetup();


$tablequote = $this->getTable('sales/quote_address');
$installer->run("
ALTER TABLE  $tablequote ADD  `date_required` datetime NULL
");

$tablequote = $this->getTable('sales/order_address');
$installer->run("
ALTER TABLE  $tablequote ADD  `date_required` datetime NULL
");

$installer->endSetup();