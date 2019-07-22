<?php

namespace Register\Form;

use Base\Form\FormBase;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class User  extends FormBase
{

    public function __construct(EntityManager  $objectManager) {
        parent::__construct('user', $objectManager);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setInputFilter(new UserFilter());
        
        $this->setAttribute('method', 'post');
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $field = new \Zend\Form\Element\Hidden('role');
        $this->add($field);

        $field = new \Zend\Form\Element\Hidden('friendlyUrl');
        $this->add($field);

        $criteria = Criteria::create();
        $criteria->where($criteria->expr()->neq('name', 'superadmin'));
        $criteria->orderBy(array('id' => 'ASC'));

        $name = new \Zend\Form\Element\Text("name");
        $name->setLabel($this->translate("Nome: *"))
            ->setAttribute('class','form-control')
            ->setAttribute('required','required')
            ->setAttribute('placeholder',$this->translate('Entre com o nome'));
        $this->add($name);

        $email = new \Zend\Form\Element\Text("email");
        $email->setLabel($this->translate("Email: *"))
            ->setAttribute('class','form-control')
            ->setAttribute('required','required')
            ->setAttribute('placeholder',$this->translate('Entre com o Email'));
        $this->add($email);

        $document = new \Zend\Form\Element\Text("document");
        $document->setLabel($this->translate("CPF: *"))
            ->setAttribute('class','form-control cpf')
            ->setAttribute('required','required');
        $this->add($document);

        $phone = new \Zend\Form\Element\Text("phone");
        $phone->setLabel($this->translate("Telefone: *"))
            ->setAttribute('class','form-control telefone')
            ->setAttribute('required','required')
            ->setAttribute('placeholder',$this->translate('Entre com o telefone'));
        $this->add($phone);

        $celphone = new \Zend\Form\Element\Text("celphone");
        $celphone->setLabel("Celular: ")
            ->setAttribute('class','form-control telefone')
            ->setAttribute('placeholder',$this->translate('Entre com o Celular'));
        $this->add($celphone);

        $field = new \Zend\Form\Element\Date("birthdate");
        $field->setLabel("Data de Nascimento: ")
            ->setAttribute('class','form-control');
        $this->add($field);

        $type = new \Zend\Form\Element\Select("gender");
        $type->setLabel($this->translate("Sexo: *"))
            ->setValueOptions(array(
                '0' => $this->translate('Masculino'),
                '1' => $this->translate('Feminino')
            ))
            ->setAttribute('required','required')
            ->setAttribute('class','form-control')
            ->setValue('0');
        $this->add($type);

        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => $this->translate('Salvar'),
                'class' => 'btn-success'
            )
        ));
    }
}
