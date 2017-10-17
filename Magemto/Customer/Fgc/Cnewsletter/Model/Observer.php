<?php

class Fgc_Cnewsletter_Model_Observer {

    public function addCustomername(Varien_Event_Observer $observer) {
        //file_put_contents(Mage::getBaseDir().'/webform.txt', print_r('test', true));
        echo 'test';exit();
    }

}
