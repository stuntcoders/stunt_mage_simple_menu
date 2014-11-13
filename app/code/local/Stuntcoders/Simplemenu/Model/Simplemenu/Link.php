<?php

class Stuntcoders_Simplemenu_Model_Simplemenu_Link extends Stuntcoders_Simplemenu_Model_Abstract
{
    public function formatMenuItem($menuItem)
    {

        unset($menuItem['type']);
        return $menuItem;
    }
}
