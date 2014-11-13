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

    public function getMenu($code)
    {
        $menuId = Mage::getModel('stuntcoders_simplemenu/simplemenu')
            ->getCollection()
            ->addCodeFilter($code)
            ->getFirstItem()->getId();

        // Menu with such code does not exist
        if (!$menuId) {
            return array();
        }
        $this->load($menuId);

        $menu = $this->_getMenuData();

        $this->_formatMenu($menu);

        return $menu;
    }

    public function getMenuOutput($code)
    {
        $menu = $this->getMenu($code);
        return "<ul id='$code'>" . $this->_outputMenu($menu['value']) . "</ul>";
    }

    protected function _formatMenu(&$menu)
    {
        foreach ($menu as &$menuItem) {
            $menuItem = $this->_formatMenuItem($menuItem);
            if (isset($menuItem["children"])) {
                $this->_formatMenu($menuItem["children"]);
            }
        }
    }

    public function _formatMenuItem($menuItem)
    {
        if (!is_array($menuItem) || empty($menuItem)) {
            return array();
        }

        if (!isset($menuItem["type"])) {
            return array();
        }

        switch ((int)$menuItem["type"]) {
            case self::MENU_ITEM_TYPE_LINK:
                $model = Mage::getModel('stuntcoders_simplemenu/simplemenu_link');
                break;
            case self::MENU_ITEM_TYPE_CATEGORY:
                $model = Mage::getModel('stuntcoders_simplemenu/simplemenu_category');
                break;
            case self::MENU_ITEM_TYPE_CMS_PAGE:
                $model = Mage::getModel('stuntcoders_simplemenu/simplemenu_cms');
                break;
            case self::MENU_ITEM_TYPE_SPECIAL:
                $model = Mage::getModel('stuntcoders_simplemenu/simplemenu_special');
                break;
            default:
                return array();
                break;
        }

//        unset($menuItem['typename']);
//        unset($menuItem['subcategories']);
//        unset($menuItem['id']);
//        unset($menuItem['type']);

        return $model->formatMenuItem($menuItem);
    }

    protected function _getMenuData()
    {
        return json_decode($this->getValue(), true);
    }

    protected function _outputMenu($menu)
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
}
