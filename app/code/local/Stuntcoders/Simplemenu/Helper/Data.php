<?php

class Stuntcoders_Simplemenu_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCategoriesArray()
    {
        return Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSort('path', 'asc')
            ->load()
            ->toArray();
    }

    public function getMenuItemDataUrl($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Simplemenu_Model_Simplemenu::MENU_ITEM_TYPE_LINK) {
            return "";
        }

        return 'data-url="'. $menuItem['url'] . '"';
    }

    public function getMenuItemDataId($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Simplemenu_Model_Simplemenu::MENU_ITEM_TYPE_CATEGORY &&
            (int)$menuItem['type'] !== Stuntcoders_Simplemenu_Model_Simplemenu::MENU_ITEM_TYPE_CMS_PAGE &&
            (int)$menuItem['type'] !== Stuntcoders_Simplemenu_Model_Simplemenu::MENU_ITEM_TYPE_SPECIAL) {
            return "";
        }

        return 'data-id="'. $menuItem['id'] . '"';
    }

    public function getMenuItemDataTypeName($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Simplemenu_Model_Simplemenu::MENU_ITEM_TYPE_SPECIAL) {
            return "";
        }

        return 'data-typename="'. $menuItem['typename'] . '"';
    }

    public function getMenuItemDataSubcategories($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Simplemenu_Model_Simplemenu::MENU_ITEM_TYPE_CATEGORY) {
            return "";
        }

        return 'data-subcategories="'. $menuItem['subcategories'] . '"';
    }
}
