<?php

class Stuntcoders_Simplemenu_SimplemenuController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function addAction()
    {
        if ($this->getRequest()->getParam('id')) {
            Mage::register('simplemenu_data',
                Mage::getModel('stuntcoders_simplemenu/simplemenu')->load($this->getRequest()->getParam('id'))
            );
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();

        if (!$postData) {
            $this->_redirect('*/*/index');
            return;
        }

        try {
            $menusModel = Mage::getModel('stuntcoders_simplemenu/simplemenu');
            $menusModel->setName($postData['name'])
                ->setCode($postData['code'])
                ->setValue($postData['simplemenu']);

            if ($this->getRequest()->getParam('id')) {
                $menusModel->setId($this->getRequest()->getParam('id'));
            }

            $menusModel->save();

            $this->getRequest()->getParam('id') ?
                $this->_redirectReferer('*/*/index') :
                $this->_redirect('*/*/add', array('id' => $menusModel->getId()));

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('stuntcoders_simplemenu')->__('Simle Menu successfully saved'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_simplemenu')->__('Simple Menu could not be saved'));

            $this->_redirectReferer('*/*/index');
        }

    }

    public function deleteAction()
    {
        if (!$this->getRequest()->getParam('id')) {
            $this->_redirect('*/*/index');
            return;
        }

        try {
            Mage::getModel('stuntcoders_simplemenu/simplemenu')
                ->load($this->getRequest()->getParam('id'))
                ->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('stuntcoders_simplemenu')->__('Simple Menu successfully deleted'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_simplemenu')->__('Simple Menu could not be deleted'));
        }

        $this->_redirect('*/*/index');
    }

    public function flushcacheAction()
    {
        if (!$this->getRequest()->getParam('id')) {
            $this->_redirect('*/*/index');
            return;
        }

        try {
            Mage::getModel('stuntcoders_simplemenu/simplemenu')
                ->load($this->getRequest()->getParam('id'))
                ->setCachedValue("")
                ->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('stuntcoders_simplemenu')->__('Simple Menus cache successfully flushed'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_simplemenu')->__('Simple Menu cache could not be flushed'));
        }

        $this->_redirectUrl($this->_getRefererUrl());
    }

    public function massDeleteAction()
    {
        $idList = $this->getRequest()->getParam('ids');
        if (!is_array($idList)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_simplemenu')->__('Please select banners(s)')
            );
        } else {
            try {
                foreach ($idList as $itemId) {
                    $model = Mage::getModel('stuntcoders_simplemenu/simplemenu')->setIsMassDelete(true)->load($itemId);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stuntcoders_simplemenu')->__(
                        'Total of %d record(s) were successfully deleted', count($idList)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
