<?php

class Stuntcoders_Simplemenu_Block_Simplemenu extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_headerText = Mage::helper('stuntcoders_simplemenu')->__('Banner Manager');
        parent::__construct();
    }

    protected function _prepareLayout()
    {
        $this->setChild('simplemenu.addnew',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('stuntcoders_simplemenu')->__('Add Simple Menu'),
                    'onclick'   => "setLocation('".$this->getUrl('*/*/add')."')",
                    'class'     => 'add'
                ))
        );
    }
}
