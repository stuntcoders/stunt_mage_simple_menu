<?php

class Stuntcoders_Simplemenu_Block_Adminhtml_Simplemenu_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('simplemenu_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getModel('stuntcoders_simplemenu/simplemenu')->getCollection());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('stuntcoders_simplemenu')->__('ID'),
            'align' =>'left',
            'width' => '100px',
            'index' => 'id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('stuntcoders_simplemenu')->__('Name'),
            'align' =>'left',
            'width' => '100px',
            'index' => 'name',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header' => Mage::helper('stuntcoders_simplemenu')->__('Store View'),
                'index' => 'store_id',
                'type' => 'store',
                'store_all' => true,
                'store_view' => true,
                'sortable' => false,
                'filter_condition_callback'
                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('store', array(
            'header' => Mage::helper('stuntcoders_simplemenu')->__('Store'),
            'align' =>'left',
            'width' => '200px',
            'index' => 'id',
        ));

        $this->addColumn('code', array(
            'header' => Mage::helper('stuntcoders_simplemenu')->__('Code'),
            'align' =>'left',
            'index' => 'code',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('stuntcoders_simplemenu')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('stuntcoders_simplemenu')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/add', array('id' => $row->getId()));
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }
}
