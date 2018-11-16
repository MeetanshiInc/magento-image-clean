<?php
class Meetanshi_ImageClean_Model_Mysql4_Imageclean extends  Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('imageclean/imageclean', 'imageclean_id');
    }    
}
