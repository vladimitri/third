<?php
class ApiController extends Zend_Controller_Action {
    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function listAction() {
//        sleep(3);
        try {
            $contacte = new Application_Models_Contacte();
            echo Zend_Json::encode(array(
                'success' => true,
                'data' => $contacte->fetchAll()->toArray()
            ));
        } catch (Exception $ex) {
            echo Zend_Json::encode(array(
                'success' => false,
                'message' => $ex->getMessage()
            ));
        }
    }
    
    public function formAction() {
        try {
            $this->view->form = $form = new Application_Forms_Editare();

            if($this->getRequest()->getParam('nume') !== null) {
                if (!$form->isValid($this->getRequest()->getParams())) {
                    echo Zend_Json::encode(array(
                        'success' => false,
                        'message' => 'Incorect'
                    ));
                } else {
                    $contacte = new Application_Models_Contacte();
                    $contact = $contacte->createRow();
                    $contact->nume = $this->getRequest()->getParam('nume');
                    $contact->data_nasterii = $this->getRequest()->getParam('data_nasterii');
                    $contact->detalii = $this->getRequest()->getParam('detalii');
                    $contact->save();
                    
                    echo Zend_Json::encode(array(
                        'success' => true
                    ));
                }
            }
        } catch (Exception $ex) {
            echo Zend_Json::encode(array(
                'success' => false,
                'message' => $ex->getMessage()
            ));
        }
    }
}
?>