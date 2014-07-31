<?php

class Stuntcoders_Menus_Block_Menus_Add_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'menus_form',
            'name'      => 'menus_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        if (Mage::registry('menu_data')) {
            $data = Mage::registry('menu_data')->getData();
        } else {
            $data = array();
        }

        $fieldset = $form->addFieldset('menus-fieldset', array(
            'legend' => Mage::helper('stuntcoders_menus')->__('Menu Information')
        ));

        $fieldset->addField('name', 'text', array(
            'label'     => Mage::helper('stuntcoders_menus')->__('Menu name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'name',
        ));

        $fieldset->addField('code', 'text', array(
            'label'     => Mage::helper('stuntcoders_menus')->__('Menu code'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'code',
        ));

        $fieldset->addField('menu-value', 'hidden', array(
            'name'      => 'menu',
        ));

        $form->setValues($data);
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}