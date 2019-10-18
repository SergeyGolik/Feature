<?php
error_reporting(E_ALL);
ini_set('memory_limit','-1');
//set_time_limit ("30000");
set_time_limit(0);
define('MAIN_INCLUDED', 1);
define('WWW_LANG_CUR', 'RU');
header('Content-type: text/html; charset=utf-8');
$pathToMage = dirname(__FILE__);
$pathToMage = str_replace('import','', $pathToMage);
require_once $pathToMage.'app/Mage.php';
Mage::app();


$categories = Mage::getModel('catalog/category')->getCollection();
$q = 1;

foreach($categories as $category) {
    if ($category->getId() != 1 && $category->getId() != 2) {
        echo $q . ' id_category = ' . $category->getId().'</br>';
        $category->setIsAnchor(1);
        $category->save();
        $q++;
    }
}
