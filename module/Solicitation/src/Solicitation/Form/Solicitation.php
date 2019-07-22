<?php
namespace Solicitation\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class Solicitation extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('solicitation', $objectManager);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Select("type");
        $field->setLabel($this->translate("Tipo de Solicitação: "))
            ->setValueOptions(array(
                '0' => $this->translate("Saque"),
                '1' => $this->translate("Renovação"),
                '2' => $this->translate("Resgate"),
                '3' => $this->translate("Primeira Comissão"),
                '4' => $this->translate("Comissão")
            ))
            ->setAttribute('value','0')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("value");
        $field->setLabel($this->translate("Valor: "))
            ->setAttribute('type','text')
            ->setAttribute('class','form-control moeda')
            ->setAttribute('moeda',"true")
            ->setAttribute('onkeypress',"mascara(this,moeda)")
            ->setAttribute('required',"required")
            ->setValue(0);
        $this->add($field);

        $field = new \Zend\Form\Element\Select("closed");
        $field->setLabel($this->translate("Atendido: "))
            ->setValueOptions(array(
                '0' => $this->translate("Não"),
                '1' => $this->translate("Sim")
            ))
            ->setAttribute('value','0')
            ->setAttribute('class','form-control');
        $this->add($field);

        $this->add(array(
            'name' => 'user_plan',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'UserPlan\Entity\UserPlan',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Aporte: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'component' => 'autocomplete'
            )
        ));

        $this->add(array(
            'name' => 'user',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Register\Entity\User',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Usuário: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'component' => 'autocomplete'
            )
        ));

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
