<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()->dropIndex($installer->getTable('stuntcoders_simplemenu/simplemenu'), 'code');

$installer->endSetup();

