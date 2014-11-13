<?php

$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE `{$this->getTable('stuntcoders_simplemenu/simplemenu')}` ADD `cached_value` text
");

$installer->endSetup();
