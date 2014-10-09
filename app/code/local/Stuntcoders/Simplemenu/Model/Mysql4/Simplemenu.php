<?php

class Stuntcoders_Simplemenu_Model_Mysql4_Simplemenu extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_simplemenu/simplemenu', 'id');
    }
}
