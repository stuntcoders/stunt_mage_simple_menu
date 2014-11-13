<?php

class Stuntcoders_Simplemenu_Model_Simplemenu_Category extends Stuntcoders_Simplemenu_Model_Abstract
{

    public function formatMenuItem($menuItem)
    {
        if ((int)$menuItem['type'] !== Stuntcoders_Simplemenu_Model_Simplemenu::MENU_ITEM_TYPE_CATEGORY) {
            return null;
        }

        $category = Mage::getModel("catalog/category")->load($menuItem['id']);
        $menuItem['url'] = $category->getUrl();

        $level = (int) $category->getLevel() + (int) $menuItem['subcategories'];

        // Add subcategories
        $tree = array();
        foreach (explode(",", $category->getAllChildren()) as $childCategory) {
            if ($menuItem['id'] == $childCategory) {
                continue;
            }
            $childCategory = Mage::getModel("catalog/category")->load($childCategory);

            if ($level < (int) $childCategory->getLevel()) {
                continue;
            }

            if ($childCategory->getParentId() === $menuItem['id']) {
                $tree[] = $this->_getSubcategoryItemMenu($childCategory);
            } else {
                $this->_createCategoriesTree($tree, $childCategory);
            }
        }

        if (!isset($menuItem['children']) || !is_array($menuItem['children'])) {
            $menuItem['children'] = array();
        }

        $menuItem['children'] = array_merge($tree, $menuItem['children']);

        return $menuItem;
    }

    private function _createCategoriesTree(&$tree, $childCategory)
    {
        foreach ($tree as $key => $node) {
            if ($node['id'] == $childCategory->getParentId()) {
                $tree[$key]["children"][] = self::_getSubcategoryItemMenu($childCategory);
            } else {
                if (isset($tree[$key]['children'])) {
                    self::_createCategoriesTree($tree[$key]['children'], $childCategory);
                }
            }
        }
    }

    private function _getSubcategoryItemMenu($category)
    {
        $temp = array();
        $temp['url'] = $category->getUrl();
        $temp['label'] = $category->getName();
        $temp['id'] = $category->getId();
        $temp['parent'] = $category->getParentId();
        return $temp;
    }
}
