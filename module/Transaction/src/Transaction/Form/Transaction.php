<?php
namespace Transaction\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class Transaction extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('transaction', $objectManager);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('method', 'post');

        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

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
                'required' => 'required',
                'component' => 'autocomplete'
            )
        ));

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
                'label' => 'Plano do Usuário: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
                'component' => 'autocomplete'
            )
        ));

        $this->add(array(
            'name' => 'cycle',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Cycle\Entity\Cycle',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Ciclo: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'category_transaction',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'CategoryTransaction\Entity\CategoryTransaction',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Categoria de Transação: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required'
            )
        ));

        $field = new \Zend\Form\Element\Select("type");
        $field->setLabel($this->translate("Tipo: *"))
            ->setValueOptions(array(
                '0' => $this->translate("Crédito"),
                '1' => $this->translate("Débito"),
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
            ->setValue(0);
        $this->add($field);

        $field = new \Zend\Form\Element\DateTime("date");
        $field->setLabel("Data da Transação: *")
            ->setAttribute('required','required')
            ->setAttribute('component','datetime')
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
