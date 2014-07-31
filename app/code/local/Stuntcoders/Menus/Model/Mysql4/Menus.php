<?php

class Stuntcoders_Menus_Model_Mysql4_Menus extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_menus/menus', 'id');
    }
}