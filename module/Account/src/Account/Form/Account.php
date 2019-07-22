<?php
namespace Account\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class Account extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('account', $objectManager);
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
            'name' => 'bank',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Bank\Entity\Bank',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Banco: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
                'component' => 'autocomplete'
            )
        ));

        $field = new \Zend\Form\Element\Text("account_number");
        $field->setLabel($this->translate("Nº da Conta: *"))
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("holder");
        $field->setLabel($this->translate("Titular da Conta: *"))
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("agency");
        $field->setLabel($this->translate("Agência: *"))
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("operation");
        $field->setLabel($this->translate("Tipo de Operação: *"))
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control')
            ->setAttribute('placeholder','Ex.: 013');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("type");
        $field->setLabel($this->translate("Tipo: "))
            ->setValueOptions(array(
                '0' => $this->translate("Corrente"),
                '1' => $this->translate("Poupança")
            ))
            ->setAttribute('value','0')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("main");
        $field->setLabel($this->translate("Principal: *"))
            ->setValueOptions(array(
                '0' => $this->translate("Não"),
                '1' => $this->translate("Sim")
            ))
            ->setAttribute('value','0')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("type_account");
        $field->setLabel($this->translate("Tipo de Pessoa: "))
            ->setValueOptions(array(
                '0' => $this->translate("Física"),
                '1' => $this->translate("Jurídica")
            ))
            ->setAttribute('value','0')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("operation");
        $field->setLabel($this->translate("Tipo de Operação: (Opcional)"))
            ->setAttribute('type','text')
            ->setAttribute('class','form-control')
            ->setAttribute('placeholder','Ex.: 013');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("cnpj");
        $field->setLabel($this->translate("CNPJ: *"))
            ->setAttribute('type','text')
            ->setAttribute('required','required')
            ->setAttribute('class','form-control cnpj');
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
