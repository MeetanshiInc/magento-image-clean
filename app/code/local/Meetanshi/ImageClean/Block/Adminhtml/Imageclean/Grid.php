<?php

class Meetanshi_ImageClean_Block_Adminhtml_Imageclean_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('Meetanshi_ImageClean_grid');
        $this->setDefaultSort('imageclean_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {

        if ($this->getRequest()->getControllerName() == 'categoryimageclean') {
            $collection = Mage::getResourceModel('imageclean/imageclean_collection')->addFieldToFilter('isproduct', 0);
        } else {
            $collection = Mage::getResourceModel('imageclean/imageclean_collection')->addFieldToFilter('isproduct', 1);
        }

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $controllerName = $this->getRequest()->getControllerName();
        $this->addColumn(
            'images',
            array(
                'header' => Mage::helper('imageclean')->__('Image'),
                'width' => '100px',
                'index' => 'imagepath',
                'align' => 'center',
                'frame_callback' => array($this, 'callback_image')
            )
        );
        $this->addColumn(
            'imagepath',
            array(
                'header' => Mage::helper('imageclean')->__('Image Path'),
                'width' => '300px',
                'index' => 'imagepath',
                'frame_callback' => array($this, 'callback_imagepath')
            )
        );
        $this->addColumn(
            'action',
            array(
                'header' => Mage::helper('imageclean')->__('Delete Action'),
                'width' => '15px',
                'type' => 'action',
                'align'=>'center',
                'getter' => 'getImageclean_id',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('imageclean')->__('Delete'),
                        'url' => array('base' => '*/' . $controllerName . '/delete'),
                        'field' => 'imageclean_id',
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'imageclean_id',
                'is_system' => true
            )
        );
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('imageclean_id');
        $this->getMassactionBlock()->setFormFieldName('imageclean_id');
        $this->getMassactionBlock()->addItem(
            'delete', array(
            'label' => Mage::helper('imageclean')->__('Delete'),
            'url' => $this->getUrl('*/*/multiDelete'),
            'confirm' => Mage::helper('imageclean')->__('Are you sure you want to delete the selected record?')
            )
        );

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function callback_image($value)
    {
        $width = 70;
        $height = 70;
        return "<img src='" . Mage::getBaseUrl('media') . $value . "' width=" . $width . " height=" . $height . "/>";

    }
    public function callback_imagepath($value)
    {
        $width = 70;
        $height = 70;
        return "<p>" . Mage::getBaseUrl('media') . $value .  "</p>";

    }
}
