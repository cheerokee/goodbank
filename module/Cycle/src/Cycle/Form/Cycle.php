<?php
namespace Cycle\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class Cycle extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('cycle', $objectManager);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Select("month");
        $field->setLabel($this->translate("Mes: *"))
            ->setValueOptions(array(
                '1' => 'Janeiro',
                '2' => 'Fevereiro',
                '3' => 'Março',
                '4' => 'Abril',
                '5' => 'Maio',
                '6' => 'Junho',
                '7' => 'Julho',
                '8' => 'Agosto',
                '9' => 'Setembro',
                '10' => 'Outubro',
                '11' => 'Novembro',
                '12' => 'Dezembro'
            ))
            ->setAttribute('value','1')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("year");
        $field->setLabel($this->translate("Ano: *"))
            ->setAttribute('type','number')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("status");
        $field->setLabel($this->translate("Ativo: "))
            ->setValueOptions(array(
                '0' => 'Inativo',
                '1' => 'Em Processo',
                '2' => 'Finalizado',
                '3' => 'Parado',
            ))
            ->setAttribute('value','0')
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
