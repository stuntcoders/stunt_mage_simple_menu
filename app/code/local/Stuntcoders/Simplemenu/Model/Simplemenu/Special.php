<?php

class Stuntcoders_Simplemenu_Model_Simplemenu_Special extends Stuntcoders_Simplemenu_Model_Abstract
{
    const MENU_ITEM_SPECIAL_LOGIN        = 1;
    const MENU_ITEM_SPECIAL_LOGOUT       = 2;
    const MENU_ITEM_SPECIAL_CART         = 3;
    const MENU_ITEM_SPECIAL_CHECKOUT     = 4;
    const MENU_ITEM_SPECIAL_WISHLIST     = 5;
    const MENU_ITEM_SPECIAL_ACCOUNT_PAGE = 6;

    public static function getPagesArray()
    {
        return array(
            self::MENU_ITEM_SPECIAL_LOGIN        => "Login",
            self::MENU_ITEM_SPECIAL_LOGOUT       => "Logout",
            self::MENU_ITEM_SPECIAL_CART         => "Cart",
            self::MENU_ITEM_SPECIAL_CHECKOUT     => "Checkout",
            self::MENU_ITEM_SPECIAL_WISHLIST     => "Wishlist",
            self::MENU_ITEM_SPECIAL_ACCOUNT_PAGE => "My Account"
        );
    }

    public function formatMenuItem($menuItem)
    {
        $menuItem['url'] = $this->_getUrl($menuItem);

        return $menuItem;
    }

    private function _getUrl($menuItem)
    {
        switch ($menuItem['id']) {
            case self::MENU_ITEM_SPECIAL_LOGIN:
                return Mage::helper('customer')->getLoginUrl();
                break;
            case self::MENU_ITEM_SPECIAL_LOGOUT:
                return Mage::helper('customer')->getLogoutUrl();
                break;
            case self::MENU_ITEM_SPECIAL_CART:
                return Mage::helper('checkout/url')->getCartUrl();
                break;
            case self::MENU_ITEM_SPECIAL_CHECKOUT:
                return Mage::helper('checkout/url')->getCheckoutUrl();
                break;
            case self::MENU_ITEM_SPECIAL_WISHLIST:
                return Mage::getUrl('wishlist');
                break;
            case self::MENU_ITEM_SPECIAL_ACCOUNT_PAGE:
                return Mage::getUrl('customer/account');
                break;
            default:
                return "";
                break;
        }
    }
}
