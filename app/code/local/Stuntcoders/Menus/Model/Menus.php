<?php

class Stuntcoders_Menus_Model_Menus extends Mage_Core_Model_Abstract
{
    const MENU_ITEM_TYPE_LINK           = 1;
    const MENU_ITEM_TYPE_CATEGORY       = 2;
    const MENU_ITEM_TYPE_CMS_PAGE       = 3;
    const MENU_ITEM_TYPE_SPECIAL        = 4;

    protected function _construct()
    {
        $this->_init('stuntcoders_menus/menus');
    }

    public static function formatMenuItem(&$menuItem)
    {
        if (!is_array($menuItem) || empty($menuItem)) {
            return null;
        }

        switch ((int)$menuItem["type"]) {
            case self::MENU_ITEM_TYPE_LINK:
                break;
            case self::MENU_ITEM_TYPE_CATEGORY:
                $menuItem['url'] = Mage::getModel("catalog/category")->load($menuItem['id'])->getUrl();
                break;
            case self::MENU_ITEM_TYPE_CMS_PAGE:
                $menuItem['url'] = Mage::helper('cms/page')->getPageUrl($menuItem['id']);
                break;
            case self::MENU_ITEM_TYPE_SPECIAL:
                $menuItem['url'] = Stuntcoders_Menus_Model_Menus_Special::getUrl($menuItem);
                break;
            default:
                unset($menuItem);
                break;
        }

        unset($menuItem['id']);
        unset($menuItem['type']);
    }
}