<?php

class Stuntcoders_Simplemenu_Model_Resource_Simplemenu_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_simplemenu/simplemenu');
        $this->_map['fields']['menu_id'] = 'main_table.id';
        $this->_map['fields']['store'] = 'simple_menu_store.store_id';
    }

    public function addCodeFilter($code)
    {
        $this->getSelect()->where('main_table.code = (?)', $code);
        return $this;
    }

    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            if (!is_array($store)) {
                $store = array($store);
            }

            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }

            $this->addFilter('store', array('in' => $store), 'public');
        }
        return $this;
    }

    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('simple_menu_store' => $this->getTable('stuntcoders_simplemenu/store')),
                'main_table.id = simple_menu_store.menu_id',
                array()
            )->group('main_table.id');

            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }
}
