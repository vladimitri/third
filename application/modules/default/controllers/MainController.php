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

    public function checkloginAction(){
        $admin = new Zend_Session_Namespace('admin');
        if(isset($admin->name)){
            echo Zend_Json::encode(array(
                'success' => true ,
                'userid' => $admin->name
            ));
        } else {
            echo Zend_Json::encode(array(
                'success' => false
            ));
        }
    }
    public function loginAction(){

        if($this->getRequest()->getParam('userid')!==null){

            if($this->getRequest()->getParam('userid')==USER && $this->getRequest()->getParam('password')==PASSWORD){
                $admin=new Zend_Session_Namespace('admin');
                $admin->name=$this->getRequest()->getParam('userid');
                echo Zend_Json::encode(array(
                    'success' => true
                ));
            } else {
                echo Zend_Json::encode(array(
                    'success' => false
                ));

            }
        } else{
            echo Zend_Json::encode(array(
                'success' => false
            ));
        }
    }

    public function logoutAction(){
        try {
            $admin = new Zend_Session_Namespace('admin');
            unset($admin->name);
            echo Zend_Json::encode(array(
                'success' => true
            ));
        } catch (Exeption $ex){
            echo Zend_Json::encode(array(
                'success' => false
            ));
        }
    }

    public function cartAction(){

        try{
            $cart = new Zend_Session_Namespace('cart');
            $products = new Application_Models_Products;
            $data = array();
            if(isset($cart->products)) {
                $data = $products->fetchAll(array('id IN (?)' => array_keys($cart->products)))->toArray();
            }
            $data['quantity'] = $cart->products;
            echo Zend_Json::encode(array(
                'success' => true ,
                'data' => $data
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

    public function addAction(){
        $uploadpath='C:/xampp/htdocs/third/uploads/';
        $products = new Application_Models_Products();
        $uploadAdapter = new Zend_File_Transfer_Adapter_Http();
        $uploadAdapter -> setDestination($uploadpath);
        if($this->getRequest()->getParam('save')!==null && $this->getRequest()->getParam('prodTitle')!==''){
            if(!$this->getRequest()->getParam('prodId')){
                $product = $products->createRow();
            } else {
                $product = $products->fetchRow(array('id = ?' => $this->getRequest()->getParam('prodId')));
            }

            $product->title = $this->getRequest()->getParam('prodTitle');
            $product->price = $this->getRequest()->getParam('prodPrice');
            $product->description = $this->getRequest()->getParam('prodDescription');
            echo $uploadAdapter->getFileName();
            $fileName = basename($uploadAdapter->getFileName());
            if ($fileName){
                if ($fileName !== $product->image && $product->image) {
                    unlink($uploadpath.$product->id.$product->image);
                }
                $product->image = $fileName;
            }
            $product->save();
            if($fileName){
                $uploadAdapter->addFilter('Rename', array('target' => $uploadAdapter->getDestination() . '/' .  $product->id.$fileName));
                $uploadAdapter ->receive();
            }

        }
    }
    public function removeAction(){
        if($this->getRequest()->getParam('id')!==null){
            $uploadpath='C:/xampp/htdocs/third/uploads/';
            $products = new Application_Models_Products();
            $product = $products->fetchRow(array('id = ?'=>$this->getRequest()->getParam('id')));
            if($product){
                if($product->image){
                    unlink($uploadpath.$product->id.$product->image);
                }
                $product->delete();
                echo Zend_Json::encode(array(
                    'success' => true
                ));
            } else {
                echo Zend_Json::encode(array(
                    'success' => false
                ));
            }
        } else {
            echo Zend_Json::encode(array(
                'success' => false
            ));
        }
    }

    public function getproductAction(){
        if($this->getRequest()->getParam('id')!==null){
            $products = new Application_Models_Products;
            $product = $products->fetchRow(array('id = ?'=>$this->getRequest()->getParam('id')));
            if($product){
                echo Zend_Json::encode(array(
                    'success'=>true ,
                    'data' => $product->toArray()
                ));
            } else {
                echo Zend_Json::encode(array(
                    'success'=>false
                ));
            }
        } else {
            echo Zend_Json::encode(array(
                'success'=>false
            ));
        }
    }

    public function checkoutAction(){
        $cart = new Zend_Session_Namespace('cart');
        if(isset($cart->products)){
            $message="Thank you! ";
            $products = new Application_Models_Products();
            $prods = $products ->fetchAll(array('id IN (?)'=>array_keys($cart->products)));
            $total = 0;

            foreach($prods as $product){
                $message .= " ".$product->title."  quantity: ".$cart->products[$product->id];
                $total += $cart->products[$product->id]*$product->price;
            }
            $message.=' Total price:'.$total;
            $headers="From:emailpentrutestareaplicatie@gmail.com";
            mail(EMAIL,"Testing",$message,$headers);
            unset($cart->products);
            echo Zend_Json::encode(array(
                'success'=> true
            ));

        } else {
            echo Zend_Json::encode(array(
                'success'=> false
            ));
        }
    }

}
?>
