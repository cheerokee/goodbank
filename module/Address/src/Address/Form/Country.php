<?php
namespace Address\Form;

use Base\Form\FormBase;
use Doctrine\ORM\EntityManager;

class Country extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('country', $objectManager);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Text("name");
        $field->setLabel($this->translate("Nome: *"))
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("abbreviation");
        $field->setLabel($this->translate("Abreviação: *"))
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value'=> $this->translate('Salvar'),
                'class' => 'btn-success'
            )
        ));
    }
}
