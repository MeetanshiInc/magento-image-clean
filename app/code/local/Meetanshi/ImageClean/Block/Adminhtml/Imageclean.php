<?php

class Meetanshi_ImageClean_Block_Adminhtml_Imageclean extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'imageclean';
        $this->_controller = 'adminhtml_imageclean';
        if($this->getRequest()->getControllerName()==="productimageclean"){
            $this->_headerText = Mage::helper('imageclean')->__('Unused Product Images');
        }else{
            $this->_headerText = Mage::helper('imageclean')->__('Unused Category Images');
        }
        
        parent::__construct();
        $this->_removeButton('add');
        $this->_addButton(
            'fetch_new', array(
            'label' => Mage::helper('imageclean')->__('Fetch New Images'),
            'onclick' => "setLocation('{$this->getUrl('*/*/new')}')",
            'class' => 'add'
            )
        );
    }
}
