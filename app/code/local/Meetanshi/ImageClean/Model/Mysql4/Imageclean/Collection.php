<?php
class Meetanshi_ImageClean_Model_Mysql4_Imageclean_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('imageclean/imageclean');
    }    
}
