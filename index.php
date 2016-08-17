<?php
    set_include_path(implode(PATH_SEPARATOR, array(
        realpath('C:\ZendFramework-1.12.19\library'),
        get_include_path(),
    )));
    require_once('config.php');

    require_once('Zend/Loader.php');
    function __autoload($className) {
        Zend_Loader::loadClass($className);
    }

    $db = Zend_Db::factory('MYSQLI', array(
        'host'     => DBSERVER,
        'username' => DBUSER,
        'password' => DBPASS,
        'dbname'   => DBDATABASE
    ));

    Zend_Db_Table::setDefaultAdapter($db);

    $front = Zend_Controller_Front::getInstance();
    $front->throwExceptions(true);
    $front->addModuleDirectory('application/modules/');
    try{
        $front->dispatch();
    }
    catch(Exception $ex) {
        print_r($ex->__toString());
    }
?>