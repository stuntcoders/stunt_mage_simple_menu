<?php

class Stuntcoders_Simplemenu_Block_Adminhtml_Simplemenu_Add_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'simplemenu_form',
            'name' => 'simplemenu_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        if (Mage::registry('simplemenu_data')) {
            $data = Mage::registry('simplemenu_data')->getData();
        } else {
            $data = array();
        }

        $fieldset = $form->addFieldset('simplemenu-fieldset', array(
            'legend' => Mage::helper('stuntcoders_simplemenu')->__('Simple Menu Information')
        ));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('stuntcoders_simplemenu')->__('Simple Menu name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('code', 'text', array(
            'label' => Mage::helper('stuntcoders_simplemenu')->__('Simple Menu code'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'code',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => Mage::helper('stuntcoders_simplemenu')->__('Store View'),
                'title' => Mage::helper('stuntcoders_simplemenu')->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
        }

        $fieldset->addField('simplemenu-value', 'hidden', array(
            'name' => 'simplemenu',
        ));

        $form->setValues($data);
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
