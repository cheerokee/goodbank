<?php
namespace PaymentMethod\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class PaymentMethod extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('payment-method', $objectManager);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Hidden('friendly_url');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("name");
        $field->setLabel($this->translate("Nome: *"))
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("active");
        $field->setLabel($this->translate("Ativo: "))
            ->setValueOptions(array(
                '0' => $this->translate("Não"),
                '1' => $this->translate("Sim")
            ))
            ->setAttribute('value','1')
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
