<?php

class Meetanshi_ImageClean_Adminhtml_CategoryimagecleanController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('imageclean'))->_title($this->__('Category Unused Images'));
        $this->loadLayout();
        $this->_setActiveMenu('imageclean');
        Mage::helper("imageclean")->Categoryunusedimage();
        $this->_addContent($this->getLayout()->createBlock('imageclean/adminhtml_imageclean'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('imageclean/adminhtml_imageclean_grid')->toHtml()
        );
    }

    public function deleteAction()
    {
        try {
            $params = $this->getRequest()->getParams('imageclean_id');
            $modeldb = Mage::getModel('imageclean/imageclean');
            $modeldb->load($params['imageclean_id']);
            $image = $modeldb->getImagepath();
            unlink('media/' . $image);
            $modeldb->delete();
            Mage::getSingleton('core/session')->addSuccess('Record delete successfully....');
            $this->_redirect('*/categoryimageclean/index');
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }
    }

    public function multiDeleteAction()
    {
        $selectedId = $this->getRequest()->getParam('imageclean_id');
        if (!is_array($selectedId)) {
            $this->_getSession()->addError($this->__('Please select record....'));
        } else {
            if (!empty($selectedId)) {
                try {
                    foreach ($selectedId as $sId) {
                        $dbModel = Mage::getModel('imageclean/imageclean');
                        $dbModel->load($sId);
                        $image = $dbModel->getImagepath();
                        unlink('media/' . $image);
                        $dbModel->delete();
                    }

                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($selectedId))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }

        $this->_redirect('*/*/index');
    }

    public function newAction()
    {
        $this->_redirect('*/*/index');
    }
    protected function _isAllowed() 
    {
        return "true";
    }



}
