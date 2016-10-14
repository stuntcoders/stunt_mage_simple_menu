<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('stuntcoders_simplemenu/store'))
    ->addColumn('menu_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
        'primary' => true,
    ), 'Menu Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Store Id')
    ->addIndex($installer->getIdxName('stuntcoders_simplemenu/store', array('store_id')),
        array('store_id'));

$installer->getConnection()->createTable($table);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('stuntcoders_simplemenu/store', 'menu_id', 'stuntcoders_simplemenu/simplemenu', 'id'),
    $installer->getTable('stuntcoders_simplemenu/store'),
    'menu_id',
    $installer->getTable('stuntcoders_simplemenu/simplemenu'),
    'id'
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('stuntcoders_simplemenu/store', 'store_id', 'core/store', 'store_id'),
    $installer->getTable('stuntcoders_simplemenu/store'),
    'store_id',
    $installer->getTable('core/store'),
    'store_id'
);

$installer->endSetup();

