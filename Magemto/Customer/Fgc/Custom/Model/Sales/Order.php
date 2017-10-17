<?php
class Fgc_Custom_Model_Sales_Order extends Mage_Sales_Model_Order{
	public function hasCustomFields(){
		$var = $this->getDateRequired();
		if($var && !empty($var)){
			return true;
		}else{
			return false;
		}
	}
	public function getFieldHtml(){
		$var = $this->getDateRequired();
		$html = '<b>Date required:</b>'.$var.'<br/>';
		return $html;
	}
}