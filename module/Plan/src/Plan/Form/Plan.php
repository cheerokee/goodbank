<?php
namespace Plan\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class Plan extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('plan', $objectManager);
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

        $field = new \Zend\Form\Element\Text("price");
        $field->setLabel($this->translate("Preço: "))
            ->setAttribute('type','text')
            ->setAttribute('class','form-control moeda')
            ->setAttribute('moeda',"true")
            ->setAttribute('onkeypress',"mascara(this,moeda)")
            ->setValue(0);
        $this->add($field);

        $field = new \Zend\Form\Element\Text("bitcoin_payment_url");
        $field->setLabel($this->translate("Url de pagamento bitcoin: *"))
            ->setAttribute('type','text')
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
