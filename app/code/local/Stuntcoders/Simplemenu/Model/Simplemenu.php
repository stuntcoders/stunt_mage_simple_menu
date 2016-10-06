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

        if ($cachedMenu = $this->getCachedValue()) {
            return json_decode($cachedMenu, true);
        }

        $menu = json_decode($this->getValue(), true);

        $this->_formatMenu($menu)->_cacheMenu($menu);

        return $menu;
    }

    public function getMenuOutput($code)
    {
        $menu = $this->getMenu($code);
        return "<ul id='{$code}'>" . $this->_outputMenu($menu) . "</ul>";
    }

    protected function _formatMenu(&$menu)
    {
        foreach ($menu as &$menuItem) {
            if (isset($menuItem['children'])) {
                $this->_formatMenu($menuItem['children']);
            }

            $menuItem = $this->_formatMenuItem($menuItem);
        }

        return $this;
    }

    public function _formatMenuItem($menuItem)
    {
        if (!is_array($menuItem) || empty($menuItem)) {
            return array();
        }

        if (!isset($menuItem['type'])) {
            return array();
        }

        switch ((int)$menuItem['type']) {
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

        if (!isset($menuItem['dummy']) || empty($menuItem['dummy'])) {
            $menuItem['dummy'] = false;
        }

        if (!isset($menuItem['newtab']) || empty($menuItem['newtab'])) {
            $menuItem['newtab'] = false;
        }

        return $model->formatMenuItem($menuItem);
    }

    protected function _cacheMenu($menu)
    {
        $this->setCachedValue(json_encode($menu))->save();

        return $this;
    }

    protected function _outputMenu($menu)
    {
        $out = '';

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
