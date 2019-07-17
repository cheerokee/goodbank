<?php
namespace PercentGain\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class PercentGain extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('percent-gain', $objectManager);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Text("value_start");
        $field->setLabel($this->translate("Valor Inicial: "))
            ->setAttribute('type','text')
            ->setAttribute('class','form-control moeda')
            ->setAttribute('moeda',"true")
            ->setAttribute('onkeypress',"mascara(this,moeda)")
            ->setValue(0);
        $this->add($field);

        $field = new \Zend\Form\Element\Text("value_finish");
        $field->setLabel($this->translate("Valor Final: "))
            ->setAttribute('type','text')
            ->setAttribute('class','form-control moeda')
            ->setAttribute('moeda',"true")
            ->setAttribute('onkeypress',"mascara(this,moeda)")
            ->setValue(0);
        $this->add($field);

        $field = new \Zend\Form\Element\Text("percent");
        $field->setLabel($this->translate("Percentual de Ganho: "))
            ->setAttribute('type','text')
            ->setAttribute('class','form-control moeda')
            ->setAttribute('moeda',"true")
            ->setAttribute('onkeypress',"mascara(this,moeda)")
            ->setValue(0);
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
