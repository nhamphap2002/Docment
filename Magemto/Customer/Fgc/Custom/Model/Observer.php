<?php
class Fgc_Custom_Model_Observer{
	public function saveQuoteBefore($evt){
		$quote = $evt->getQuote();
		$post = Mage::app()->getFrontController()->getRequest()->getPost();
		if(isset($post['custom']['date_required'])){
			$var = $post['custom']['date_required'];
			$quote->setSsn($var);
		}
	}
	public function saveQuoteAfter($evt){
		$quote = $evt->getQuote();
		if($quote->getDateRequired()){
			$var = $quote->getDateRequired();
			if(!empty($var)){
				$model = Mage::getModel('custom/custom_quote');
				$model->deteleByQuote($quote->getId(),'date_required');
				$model->setQuoteId($quote->getId());
				$model->setKey('date_required');
				$model->setValue($var);
				$model->save();
			}
		}
	}
	public function loadQuoteAfter($evt){
		$quote = $evt->getQuote();
		$model = Mage::getModel('custom/custom_quote');
		$data = $model->getByQuote($quote->getId());
		foreach($data as $key => $value){
			$quote->setData($key,$value);
		}
	}
	public function saveOrderAfter($evt){
		$order = $evt->getOrder();
		$quote = $evt->getQuote();
		if($quote->getDateRequired()){
			$var = $quote->getDateRequired();
			if(!empty($var)){
				$model = Mage::getModel('custom/custom_order');
				$model->deleteByOrder($order->getId(),'date_required');
				$model->setOrderId($order->getId());
				$model->setKey('date_required');
				$model->setValue($var);
				$order->setSsn($var);
				$model->save();
			}
		}
	}
	public function loadOrderAfter($evt){
		$order = $evt->getOrder();
		$model = Mage::getModel('custom/custom_order');
		$data = $model->getByOrder($order->getId());
		foreach($data as $key => $value){
			$order->setData($key,$value);
		}
	}

}