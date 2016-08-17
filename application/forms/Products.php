<?php
class Application_Models_Products extends Zend_Db_Table_Abstract{
	protected $_name	='products';
	protected $_primary	='id';
	protected $_rowClass='Application_Models_Product';
}

?>