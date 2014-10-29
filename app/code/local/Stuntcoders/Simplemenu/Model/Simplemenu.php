<?php

class Stuntcoders_Simplemenu_Model_Simplemenu extends Mage_Core_Model_Abstract
{
    const MENU_ITEM_TYPE_LINK           = 1;
    const MENU_ITEM_TYPE_CATEGORY       = 2;
    const MENU_ITEM_TYPE_CMS_PAGE       = 3;
    const MENU_ITEM_TYPE_SPECIAL        = 4;

    protected function _construct()
    {
        $this->_init('stuntcoders_simplemenu/simplemenu');
    }

    public static function formatMenuItem(&$menuItem)
    {
        if (!is_array($menuItem) || empty($menuItem)) {
            return;
        }

        if (!isset($menuItem["type"])) {
            return;
        }

        switch ((int)$menuItem["type"]) {
            case self::MENU_ITEM_TYPE_LINK:
                break;
            case self::MENU_ITEM_TYPE_CATEGORY:
                Stuntcoders_Simplemenu_Model_Simplemenu_Category::formatMenuItem($menuItem);
                break;
            case self::MENU_ITEM_TYPE_CMS_PAGE:
                Stuntcoders_Simplemenu_Model_Simplemenu_Cms::formatMenuItem($menuItem);
                break;
            case self::MENU_ITEM_TYPE_SPECIAL:
                Stuntcoders_Simplemenu_Model_Simplemenu_Special::formatMenuItem($menuItem);
                break;
            default:
                unset($menuItem);
                break;
        }

        unset($menuItem['typename']);
        unset($menuItem['subcategories']);
        unset($menuItem['id']);
        unset($menuItem['type']);
    }
}
