<?php

class Stuntcoders_Menus_Block_Menus_Add extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('banner/add.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('menu.save',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('stuntcoders_menus')->__('Save Menu'),
                    'onclick'   => "menus_form.submit()",
                    'class'     => 'add'
                ))
        );

        $this->setChild('menu.delete',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('stuntcoders_menus')->__('Delete Menu'),
                    'onclick'   => "setLocation('".$this->getUrl('*/*/delete',
                            array('id' => $this->getRequest()->getParam('id')))."')",
                    'class'     => 'delete'
                ))
        );
    }
}