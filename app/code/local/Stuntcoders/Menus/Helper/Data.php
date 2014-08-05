<?php

class Stuntcoders_Menus_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getMenu($code)
    {
        $menuData = Mage::getModel('stuntcoders_menus/menus')
            ->getCollection()
            ->addCodeFilter($code)
            ->getData();

        if (!isset($menuData[0])) {
            return array();
        }

        $menuData = $menuData[0];
        $menuData["value"] = json_decode($menuData["value"], true);

        $this->_formateMenuItems($menuData["value"]);

        return $menuData;
    }

    public function getCategoriesArray()
    {
        return Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSort('path', 'asc')
            ->load()
            ->toArray();
    }

    private function _formateMenuItems(&$menuItems)
    {
        foreach ($menuItems as &$menuItem) {
            Stuntcoders_Menus_Model_Menus::formatMenuItem($menuItem);
            if (isset($menuItem["children"])) {
                $this->_formateMenuItems($menuItem["children"]);
            }
        }
    }

    public function getMenuItemDataUrl($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Menus_Model_Menus::MENU_ITEM_TYPE_LINK) {
           return "";
        }

        return 'data-url="'. $menuItem['url'] . '"';
    }

    public function getMenuItemDataId($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Menus_Model_Menus::MENU_ITEM_TYPE_CATEGORY &&
            (int)$menuItem['type'] !== Stuntcoders_Menus_Model_Menus::MENU_ITEM_TYPE_CMS_PAGE) {
            return "";
        }

        return 'data-id="'. $menuItem['id'] . '"';
    }

    public function getMenuItemDataTypeName($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Menus_Model_Menus::MENU_ITEM_TYPE_SPECIAL) {
            return "";
        }

        return 'data-typename="'. $menuItem['typename'] . '"';
    }

    public function getMenuItemDataSubcategories($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Menus_Model_Menus::MENU_ITEM_TYPE_CATEGORY) {
            return "";
        }

        return 'data-subcategories="'. $menuItem['subcategories'] . '"';
    }
}