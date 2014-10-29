<?php

class Stuntcoders_Simplemenu_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getMenu($code)
    {
        $menuData = Mage::getModel('stuntcoders_simplemenu/simplemenu')
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

    private function _outputMenu($menu)
    {
        $out = "";

        foreach ($menu as $menuItem) {
            $out .= "<li><a href='{$menuItem['url']}'>{$menuItem['label']}</a>";

            if (!empty($menuItem['children'])) {
                $out .= "<ul>" . $this->_outputMenu($menuItem['children']) . "</ul>";
            }
            $out .= "</li>";
        }

        return $out;
    }

    public function getMenuOutput($code)
    {
        $mainMenu = Mage::helper('stuntcoders_simplemenu')->getMenu('main_menu');
        return "<ul id='$code'>" . $this->_outputMenu($mainMenu['value']) . "</ul>";
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
            Stuntcoders_Simplemenu_Model_Simplemenu::formatMenuItem($menuItem);
            if (isset($menuItem["children"])) {
                $this->_formateMenuItems($menuItem["children"]);
            }
        }
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
            (int)$menuItem['type'] !== Stuntcoders_Simplemenu_Model_Simplemenu::MENU_ITEM_TYPE_CMS_PAGE) {
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
