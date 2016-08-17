<?php
class IndexController extends Zend_Controller_Action {
    public function indexAction() {
        $contacte = new Application_Models_Contacte();
        $this->view->contacte = $contacte->fetchAll();
    }
    
    public function adaugaAction() {
        $this->view->form = $form = new Application_Forms_Editare();

        if($this->getRequest()->getParam('nume') !== null) {
            if (!$form->isValid($this->getRequest()->getParams())) {
                $this->view->mesaj = 'Incorect';
            } else {
                $contacte = new Application_Models_Contacte();
                $contact = $contacte->createRow();
                $contact->nume = $this->getRequest()->getParam('nume');
                $contact->data_nasterii = $this->getRequest()->getParam('data_nasterii');
                $contact->detalii = $this->getRequest()->getParam('detalii');
                $contact->save();
                
                $this->_helper->redirector->gotoUrl('/');
            }
        }
    }
}
?>