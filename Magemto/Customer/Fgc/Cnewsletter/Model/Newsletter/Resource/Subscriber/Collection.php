<?php

class Fgc_Cnewsletter_Model_Newsletter_Resource_Subscriber_Collection extends Mage_Newsletter_Model_Resource_Subscriber_Collection {
    
    /**
     * Constructor
     * Configures collection
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('newsletter/subscriber');
        $this->_queueLinkTable = $this->getTable('newsletter/queue_link');
        $this->_storeTable = $this->getTable('core/store');


        // defining mapping for fields represented in several tables
        //$this->_map['fields']['customer_lastname'] = 'customer_lastname_table.value';
        //$this->_map['fields']['customer_firstname'] = 'customer_firstname_table.value';
        $this->_map['fields']['type'] = $this->getResource()->getReadConnection()
            ->getCheckSql('main_table.customer_id = 0', 1, 2);
        $this->_map['fields']['website_id'] = 'store.website_id';
        $this->_map['fields']['group_id'] = 'store.group_id';
        $this->_map['fields']['store_id'] = 'main_table.store_id';
    }

    /**
     * Adds customer info to select
     *
     * @return Mage_Newsletter_Model_Resource_Subscriber_Collection
     */
    public function showCustomerInfo() {
        $adapter = $this->getConnection();
        $customer = Mage::getModel('customer/customer');
        $firstname = $customer->getAttribute('firstname');
        $lastname = $customer->getAttribute('lastname');

        $this->getSelect()->columns(array('fname' => 'COALESCE(`customer_firstname_table`.`value`, s_firstname)'));
        $this->getSelect()->columns(array('lname' => 'COALESCE(`customer_lastname_table`.`value`, s_lastname)'));
        $this->getSelect()
                ->joinLeft(
                        array('customer_lastname_table' => $lastname->getBackend()->getTable()), $adapter->quoteInto('customer_lastname_table.entity_id=main_table.customer_id
                 AND customer_lastname_table.attribute_id = ?', (int) $lastname->getAttributeId()), array('customer_lastname' => 'value')
                )
                ->joinLeft(
                        array('customer_firstname_table' => $firstname->getBackend()->getTable()), $adapter->quoteInto('customer_firstname_table.entity_id=main_table.customer_id
                 AND customer_firstname_table.attribute_id = ?', (int) $firstname->getAttributeId()), array('customer_firstname' => 'value')
        );

        return $this;
    }

}
