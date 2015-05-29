<?php

class Stuntcoders_Simplemenu_Model_Resource_Simplemenu extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_simplemenu/simplemenu', 'id');
    }
}
