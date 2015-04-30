<?php

class Stuntcoders_Simplemenu_Block_Simplemenu extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
        if (!$this->getCode()) {
            return '';
        }

        return Mage::getModel('stuntcoders_simplemenu/simplemenu')->getMenuOutput($this->getCode());
    }
}