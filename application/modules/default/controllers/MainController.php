<?php
class MainController extends Zend_Controller_Action{

    public function init(){
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function listAction(){
        try{
            $products = new Application_Models_Products();
            echo Zend_Json::encode(array(
                'success' => true ,
                'data' =>$products->fetchAll()->toArray()
            ));
        } catch (Exception $ex){
            echo Zend_Json::encode(array(
                'success' => false ,
                'message' => $ex->getMessage()
            ));
        }

    }

}


?>
