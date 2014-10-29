<?php

class Stuntcoders_Simplemenu_Model_Simplemenu_Cms extends Mage_Core_Model_Abstract
{
    public static function formatMenuItem(&$menuItem)
    {
        $menuItem['url'] = Mage::helper('cms/page')->getPageUrl($menuItem['id']);
    }
}
