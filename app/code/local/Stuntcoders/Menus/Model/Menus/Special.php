<?php

class Stuntcoders_Menus_Model_Menus_Special extends Mage_Core_Model_Abstract
{
    const MENU_ITEM_SPECIAL_LOGIN       = 1;
    const MENU_ITEM_SPECIAL_LOGOUT      = 2;
    const MENU_ITEM_SPECIAL_CART        = 3;
    const MENU_ITEM_SPECIAL_CHECKOUT    = 4;

    public static function getUrl($menuItem)
    {
        switch ($menuItem['id']) {
            case self::MENU_ITEM_SPECIAL_LOGIN: return Mage::helper('customer')->getLoginUrl(); break;
            case self::MENU_ITEM_SPECIAL_LOGOUT: return Mage::helper('customer')->getLogoutUrl(); break;
            case self::MENU_ITEM_SPECIAL_CART: return Mage::helper('checkout/url')->getCartUrl(); break;
            case self::MENU_ITEM_SPECIAL_CHECKOUT: return Mage::helper('checkout/url')->getCheckoutUrl(); break;
            default: return ""; break;
        }
    }
}