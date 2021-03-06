<?php

$menuModel = Mage::getModel('stuntcoders_simplemenu/simplemenu');

// Add logged out menu
Mage::getModel('stuntcoders_simplemenu/simplemenu')->setName('Logged out top')
    ->setCode('logged_out_top')
    ->setValue('[{"type":4,"label":"Cart","typename":"Cart","id":"3","dummy":false,"newtab":false},{"type":4,"label":"Login","typename":"Login","id":"1","dummy":false,"newtab":false}]')
    ->save();

// Add logged in menu
Mage::getModel('stuntcoders_simplemenu/simplemenu')->setName('Logged in top')
    ->setCode('logged_in_top')
    ->setValue('[{"type":4,"label":"Cart","typename":"Cart","id":"3","dummy":false,"newtab":false},{"type":4,"label":"Account page","typename":"Account page","id":"6","dummy":false,"newtab":false},{"type":4,"label":"Logout","typename":"Logout","id":"2","dummy":false,"newtab":false}]')
    ->save();
