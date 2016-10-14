<?php

class Stuntcoders_Simplemenu_Model_Resource_Simplemenu extends Mage_Core_Model_Resource_Db_Abstract
{
    protected $_store = null;

    protected function _construct()
    {
        $this->_init('stuntcoders_simplemenu/simplemenu', 'id');
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $where = array(
            'menu_id = ?' => (int) $object->getId(),
        );
        $table  = $this->getTable('stuntcoders_simplemenu/store');

        $this->_getWriteAdapter()->delete($table, $where);

        return parent::_beforeDelete($object);
    }

    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = $object->getStores();
        if (empty($newStores)) {
            $newStores = $object->getStoreId();
        }
        $table  = $this->getTable('stuntcoders_simplemenu/store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = array(
                'menu_id = ?' => $object->getId(),
                'store_id IN (?)' => $delete
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insert) {
            $data = array();

            foreach ($insert as $storeId) {
                $data[] = array(
                    'menu_id' => $object->getId(),
                    'store_id' => $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        Mage::app()->getCacheInstance()->invalidateType('layout');

        return parent::_afterSave($object);
    }

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());

            $object->setData('store_id', $stores);
        }

        return parent::_afterLoad($object);
    }

    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, $object->getStoreId());
            $select->join(
                array('simple_menu_store' => $this->getTable('stuntcoders_simplemenu/store')),
                $this->getMainTable() . '.id = simple_menu_store.menu_id',
                array())
                ->where('simple_menu_store.menu_id IN (?)', $storeIds)
                ->order('simple_menu_store.menu_id DESC')
                ->limit(1);
        }

        return $select;
    }

    protected function _getLoadByIdentifierSelect($identifier, $store)
    {
        $select = $this->_getReadAdapter()->select()
            ->from(array('simple_menu' => $this->getMainTable()))
            ->join(
                array('simple_menu_store' => $this->getTable('stuntcoders_simplemenu/store')),
                'simple_menu.id = simple_menu_store.menu_id',
                array())
            ->where('simple_menu.id = ?', $identifier)
            ->where('simple_menu_store.store_id IN (?)', $store);

        return $select;
    }

    public function getIsUniqueSimpleMenuToStores(Mage_Core_Model_Abstract $object)
    {
        if (!$object->hasStores()) {
            $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
        } else {
            $stores = (array)$object->getData('stores');
        }

        $select = $this->_getLoadByIdentifierSelect($object->getData('identifier'), $stores);

        if ($object->getId()) {
            $select->where('simple_menu_store.page_id <> ?', $object->getId());
        }

        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }

        return true;
    }

    public function checkIdentifier($identifier, $storeId)
    {
        $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID, $storeId);
        $select = $this->_getLoadByIdentifierSelect($identifier, $stores, 1);
        $select->reset(Zend_Db_Select::COLUMNS)
            ->columns('simple_menu.menu_id')
            ->order('simple_menu_store.store_id DESC')
            ->limit(1);

        return $this->_getReadAdapter()->fetchOne($select);
    }

    public function getSimpleMenuNameByIdentifier($identifier)
    {
        $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
        if ($this->_store) {
            $stores[] = (int)$this->getStore()->getId();
        }

        $select = $this->_getLoadByIdentifierSelect($identifier, $stores);
        $select->reset(Zend_Db_Select::COLUMNS)
            ->columns('simple_menu.name')
            ->order('simple_menu_store.store_id DESC')
            ->limit(1);

        return $this->_getReadAdapter()->fetchOne($select);
    }

    public function lookupStoreIds($menuId)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('stuntcoders_simplemenu/store'), 'store_id')
            ->where('menu_id = ?', $menuId);

        return $adapter->fetchCol($select);
    }

    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }

    public function getStore()
    {
        return Mage::app()->getStore($this->_store);
    }
}
