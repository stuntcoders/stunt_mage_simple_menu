<?php

class Stuntcoders_Menus_MenusController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function addAction()
    {
        if ($this->getRequest()->getParam('id')) {
            Mage::register('menu_data',
                Mage::getModel('stuntcoders_menus/menus')->load($this->getRequest()
                    ->getParam('id'))
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
            $menusModel = Mage::getModel('stuntcoders_menus/menus');
            $menusModel->setName($postData['name'])
                ->setCode($postData['code'])
                ->setValue($postData['menu']);

            if ($this->getRequest()->getParam('id')) {
                $menusModel->setId($this->getRequest()->getParam('id'));
            }

            $menusModel->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('stuntcoders_menus')->__('Menu successfully saved'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_menus')->__('Menu could not be saved'));
        }

        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        if (!$this->getRequest()->getParam('id')) {
            $this->_redirect('*/*/index');
            return;
        }

        try {
            Mage::getModel('stuntcoders_menus/menus')
                ->load($this->getRequest()->getParam('id'))
                ->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('stuntcoders_menus')->__('Menu successfully deleted'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_menus')->__('Menu could not be deleted'));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        $idList = $this->getRequest()->getParam('ids');
        if (!is_array($idList)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_menus')->__('Please select banners(s)')
            );
        } else {
            try {
                foreach ($idList as $itemId) {
                    $model = Mage::getModel('stuntcoders_menus/menus')->setIsMassDelete(true)->load($itemId);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stuntcoders_menus')->__(
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