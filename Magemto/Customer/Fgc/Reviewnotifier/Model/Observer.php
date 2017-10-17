<?php

class Fgc_Reviewnotifier_Model_Observer {

    /**
     * Send notification email when product review is posted
     *
     * @param Varien_Event_Observer $observer
     */
    public function reviewSaveAfter(Varien_Event_Observer $observer) {
        $review = $observer->object;
        if ($review) {
            $receiver_email = array('enquiries@customgear.com.au');
            try {
                $this->_sendNotificationEmail($receiver_email, $review);
            } catch (Exception $e) {
                Mage::logException($e);
            }
        } else {
            Mage::log('ERROR::UNABLE TO LOAD REVIEW');
        }
    }

    protected function _sendNotificationEmailBK($emails, $review) {
        if (count($emails)) {
            $product = Mage::getModel('catalog/product')->load($review->getEntityPkValue());
            $starRatings = array_values($review->getRatings());

            $body = 'A new review has been added<br /><br />';
            $body .= 'Customer Name: ' . $review->getNickname() . '<br />';
            //$body .= 'Product: ' . sprintf('<a href="%s" target="_blank">%s</a>', $product->getProductUrl(), $product->getName()) . '<br />';
            //$body .= 'Review Title: ' . $review->getTitle() . '<br />';
            $body .= 'Review Text: ' . $review->getDetail() . '<br />';

            foreach ($emails as $toEmail) {
                $mail = Mage::getModel('core/email');
                $mail->setToName('CustomGear site');
                $mail->setToEmail($toEmail);
                $mail->setBody($body);
                $mail->setSubject('CustomGear site: New Product Review');
                $mail->setFromEmail('donotreply@yourstore.com');
                $mail->setFromName("CustomGear site");
                $mail->setType('html');

                try {
                    $mail->send();
                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }
        }
    }

    protected function _sendNotificationEmail($emails, $review) {
        if (count($emails)) {
            foreach ($emails as $toEmail) {
                $emailTemplate = Mage::getModel('core/email_template');

                $emailTemplate->loadDefault('review_notify');
                $emailTemplate->setTemplateSubject('CustomGear site: New Product Review');

                // Get General email address (Admin->Configuration->General->Store Email Addresses)
                $salesData['email'] = Mage::getStoreConfig('trans_email/ident_general/email');
                $salesData['name'] = Mage::getStoreConfig('trans_email/ident_general/name');

                $emailTemplate->setSenderName($salesData['name']);
                $emailTemplate->setSenderEmail($salesData['email']);

                $emailTemplateVariables['review_text'] = $review->getDetail();
                try{
                    $emailTemplate->send($toEmail, 'CustomGear site', $emailTemplateVariables);
                } catch (Exception $ex) {
                    Mage::logException($ex);
                }
                
            }
        }
    }

}
