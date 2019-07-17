<?php
namespace UserPlan\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class UserPlan extends FormBase{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct('user-plan', $objectManager);
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
                'component' => 'autocomplete'
            )
        ));

        $this->add(array(
            'name' => 'plan',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Plan\Entity\Plan',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Plano: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'payment_method',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'PaymentMethod\Entity\PaymentMethod',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Forma de Pagamento: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'wallet',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Wallet\Entity\Wallet',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Carteira: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'component' => 'autocomplete'
            )
        ));

        $this->add(array(
            'name' => 'account',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Account\Entity\Account',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Conta Bancária Vinculada: ',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'component' => 'autocomplete'
            )
        ));

        $this->add(array(
            'name' => 'first_cycle',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Cycle\Entity\Cycle',
                //'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => 'Selecione...',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAll',
                    'params' => array()
                ),
                'label' => 'Primeiro Ciclo: *',
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control'
            )
        ));

        $field = new \Zend\Form\Element\File("receipt");
        $field->setLabel('Comprovante: ')
            ->setAttribute('class','form-control')
            ->setAttribute('accept','.gif,.jpg,.jpeg,.png,.doc,.docx,.pdf')
            ->setAttribute('component','file')
            ->setAttribute('placeholder','Faça upload do comprovante de depósito');
        $this->add($field);

        $field = new \Zend\Form\Element\Select("status");
        $field->setLabel($this->translate("Status: "))
            ->setValueOptions(array(
                '0' => $this->translate("Inativo"),
                '1' => $this->translate("Ativo"),
                '2' => $this->translate("Resgate Solicitado"),
                '3' => $this->translate("Resgatado"),
                '4' => $this->translate("Cancelado")
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
