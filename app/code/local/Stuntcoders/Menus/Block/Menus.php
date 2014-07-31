<?php

class Stuntcoders_Menus_Block_Menus extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_headerText = Mage::helper('stuntcoders_menus')->__('Banner Manager');
        parent::__construct();
    }

    protected function _prepareLayout()
    {
        $this->setChild('menus.addnew',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('stuntcoders_menus')->__('Add Menu'),
                    'onclick'   => "setLocation('".$this->getUrl('*/*/add')."')",
                    'class'     => 'add'
                ))
        );
    }
}
