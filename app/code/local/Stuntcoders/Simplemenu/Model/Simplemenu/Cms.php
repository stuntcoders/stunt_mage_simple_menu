<?php

class Stuntcoders_Simplemenu_Model_Simplemenu_Cms extends Stuntcoders_Simplemenu_Model_Abstract
{
    public function formatMenuItem($menuItem)
    {
        $menuItem['url'] = Mage::helper('cms/page')->getPageUrl($menuItem['id']);

        return $menuItem;
    }
}
