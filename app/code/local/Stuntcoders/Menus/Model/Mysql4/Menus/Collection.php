<?php

class Stuntcoders_Menus_Model_Mysql4_Menus_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_menus/menus');
    }

    public function addCodeFilter($code)
    {
        $this->getSelect()->where('main_table.code = (?)', $code);
        return $this;
    }
}
