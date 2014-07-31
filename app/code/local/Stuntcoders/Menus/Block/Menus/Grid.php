<?php

class Stuntcoders_Menus_Block_Menus_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('menus_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getModel('stuntcoders_menus/menus')->getCollection());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('stuntcoders_menus')->__('ID'),
            'align'     =>'left',
            'width'     => '100px',
            'index'     => 'id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('stuntcoders_menus')->__('Name'),
            'align'     =>'left',
            'width'     => '100px',
            'index'     => 'name',
        ));

        $this->addColumn('code', array(
            'header'    => Mage::helper('stuntcoders_menus')->__('Code'),
            'align'     =>'left',
            'index'     => 'code',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('stuntcoders_menus')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('stuntcoders_menus')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/add', array('id' => $row->getId()));
    }
}