<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('stuntcoders_menus/menus')}`;
CREATE TABLE `{$this->getTable('stuntcoders_menus/menus')}` (
    `id` smallint(6) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `code` varchar(255) NOT NULL,
    `value` text NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Menu instance' ;
");

$installer->endSetup();