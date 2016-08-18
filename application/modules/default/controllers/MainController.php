<?php
class MainController extends Zend_Controller_Action{

    public function init(){
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function getproductsAction(){
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

    public function loginAction(){
        $this->view->form = $form = new Application_Forms_Login();
        if($this->getRequest()->getParam('id')!==null){
            if($this->getRequest()->getParam('id')==USER && $this->getRequest()->getParam('password')==PASSWORD){
                $admin=new Zend_Session_Namespace('admin');
                $admin->name=$this->getRequest()->getParam('id');
                $this->_helper->redirector->gotoUrl('/');
            } else {
                $this->view->message='Wrong login';
            }
        }
    }

    public function logoutAction(){
        $admin = new Zend_Session_Namespace('admin');
        unset($admin->name);
        $this->_helper->redirector->gotoUrl('/');
    }

    public function cartAction(){

        try{
            $cart = new Zend_Session_Namespace('cart');
            $products = new Application_Models_Products;
            $data = array();
            if(isset($cart->products)) {
                $data = $products->fetchAll(array('id IN (?)' => array_keys($cart->products)))->toArray();
            }
            echo Zend_Json::encode(array(
                'success' => true ,
                'data' => $data,
                'quantity' =>$cart->products
            ));

        } catch (Exception $ex) {
            echo Zend_Json::encode(array(
                'success' => false,
                'message' => $ex->getMessage()
            ));
        }

    }

    public function addtocartAction(){
        if($this->getRequest()->getParam('id')){
            $id = $this->getRequest()->getParam('id');
            if($id) {
                try {
                    $cart = new Zend_Session_Namespace('cart');
                    if (!isset($cart->products)) {
                        $cart->products = array();
                    }
                    if (isset($cart->products[$id])) {
                        $cart->products[$id]++;
                    } else {
                        $cart->products[$id] = 1;
                    }
                    echo Zend_Json::encode(array(
                        'success' => true
                    ));
                } catch (Exception $ex) {
                    echo Zend_Json::encode(array(
                        'success' => false,
                        'message' => $ex->getMessage()
                    ));
                }
            } else {
                echo Zend_Json::encode(array(
                    'success' => false,
                    'message' => 'no id'.'error 2'
                ));
            }
        }
    }
    public function removefromcartAction(){
        if($this->getRequest()->getParam('id')){
            $id = $id = $this->getRequest()->getParam('id');
            if($id){
                try{
                    $cart = new Zend_Session_Namespace('cart');
                    if(isset($cart->products[$id]) && $cart->products[$id]>1){
                        $cart->products[$id]--;
                    } else if($cart->products[$id] == 1){
                        unset($cart->products[$id]);
                    }
                    if(count($cart->products)==0){
                        unset($cart->products);
                    }
                    echo Zend_Json :: encode(array(
                        'success' => true
                    ));

                } catch (Exception $ex){
                    echo Zend_Json :: encode(array(
                        'success' => false
                    ));
                }
            } else {
                echo Zend_Json :: encode(array(
                    'success' => false
                ));
            }
        }
    }

}


?>
