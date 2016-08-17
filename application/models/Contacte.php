<?php
class Application_Models_Contacte extends Zend_Db_Table_Abstract {
    protected $_name            = 'contacte';
    protected $_primary         = 'id';
    protected $_rowClass        = 'Application_Models_Contact';
}
?>