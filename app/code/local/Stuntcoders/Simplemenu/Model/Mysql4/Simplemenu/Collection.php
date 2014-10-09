<?php

class Stuntcoders_Simplemenu_Model_Mysql4_Simplemenu_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_simplemenu/simplemenu');
    }

    public function addCodeFilter($code)
    {
        $this->getSelect()->where('main_table.code = (?)', $code);
        return $this;
    }
}