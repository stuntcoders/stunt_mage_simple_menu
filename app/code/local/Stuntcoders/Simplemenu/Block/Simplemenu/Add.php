<?php

class Stuntcoders_Simplemenu_Block_Simplemenu_Add extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _prepareLayout()
    {
        $this->setChild('simplemenu.save',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('stuntcoders_simplemenu')->__('Save'),
                    'onclick'   => "simplemenu_form.submit()",
                    'class'     => 'add'
                ))
        );

        $this->setChild('simplemenu.delete',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('stuntcoders_simplemenu')->__('Delete'),
                    'onclick'   => "deleteConfirm('"
                        . Mage::helper('stuntcoders_simplemenu')->__('Are you sure you want to delete?') . "', '"
                        . $this->getUrl('*/*/delete', array('id' => $this->getRequest()->getParam('id'))) . "')",
                    'class'     => 'delete'
                ))
        );

        $this->setChild('simplemenu.flush_cache',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('stuntcoders_simplemenu')->__('Flush Cache'),
                    'onclick'   => "setLocation('" . $this->getUrl('*/*/flushcache',
                            array('id' => $this->getRequest()->getParam('id'))) . "')",
                    'class'     => 'delete'
                ))
        );
    }
}
