<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('stuntcoders_simplemenu/simplemenu')}`;
CREATE TABLE `{$this->getTable('stuntcoders_simplemenu/simplemenu')}` (
    `id` smallint(6) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `code` varchar(255) NOT NULL,
    `value` text NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Simple Menu instance' ;
");

$installer->endSetup();
