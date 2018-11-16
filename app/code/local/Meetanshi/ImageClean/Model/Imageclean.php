<?php
class Meetanshi_ImageClean_Model_Imageclean extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('imageclean/imageclean');
    }
}
