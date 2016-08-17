<?php
class Application_Forms_Editare extends Zend_Form {
    public function init() {
        $validator = new Zend_Validate_NotEmpty();
        $validator->setMessage('Nu poate fi gol');

        $campNume = new Zend_Form_Element_Text('nume');
        $campNume->setLabel('Nume')
            ->setRequired(true)
            ->addValidator($validator);

        $campData = new Zend_Form_Element_Text('data_nasterii');
        $campData->setLabel('Data nasterii')
            ->setRequired(true)
            ->addValidator($validator);
            
        $campDetalii = new Zend_Form_Element_Textarea('detalii');
        $campDetalii->setLabel('Detalii');
            
        $buton = new Zend_Form_Element_Submit('submit');
        $buton->setLabel('OK');
        
        $this->addElements(array($campNume, $campData, $campDetalii, $buton));
    }
}
?>
