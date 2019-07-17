<?php

namespace Address\Form;

use Base\Form\FormBase;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;

class Address  extends FormBase
{

    public function __construct(EntityManager  $objectManager) {
        parent::__construct('address', $objectManager);
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

        $field = new \Zend\Form\Element\Text("address");
        $field->setLabel($this->translate("Logradouro: *"))
            ->setAttribute('class','form-control')
            ->setAttribute('required','required');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("number");
        $field->setLabel($this->translate("Número: "))
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("neighborhood");
        $field->setLabel($this->translate("Bairro: "))
            ->setAttribute('class','form-control');
        $this->add($field);

        $field = new \Zend\Form\Element\Text("zip_code");
        $field->setLabel($this->translate("CEP: "))
            ->setAttribute('class','form-control cep')
            ->setAttribute('onkeypress',"mascara(this,mCEP)");
        $this->add($field);

        $field = new \Zend\Form\Element\Text("complement");
        $field->setLabel($this->translate("Complemento: "))
            ->setAttribute('class','form-control');
        $this->add($field);

        $this->add(array(
            'name' => 'country',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Address\Entity\Country',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => $this->translate('Selecione...'),
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('id' => 'ASC'),
                    )
                ),
                'label' => $this->translate('País: *'),
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'state',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Address\Entity\State',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => $this->translate('Selecione...'),
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('id' => 'ASC'),
                    )
                ),
                'label' => $this->translate('Estado: *'),
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
                /*
                 * Esse componente tem a função de obedecer a mudança de um determinado campo da tabela
                 * A tabela pai (master field) deve ter relação com a tabela filho (Referenciado nesse campo atual)
                 */
                'component' => 'join-select',
                /*
                master_field = É o campo dessa mesma tabela que ao ser alterada muda esta
                fk_table = É a tabela filha deve ser passado o nome da tabela do apigility
                fk_field = É o campo da tabela filha que é ligada com a tabela pai
                father_type = O tipo do campo pai é input ou select?
                */
                'component_params' => '{
                    "master_field" : "country",
                    "fk_table" : "state",
                    "fk_field" : "country",
                    "father_type":"select",
                    "placeholder":"Selecione o país primeiro"
                }'
            )
        ));

        $this->add(array(
            'name' => 'city',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'disable_inarray_validator' => true,
                'object_manager' => $objectManager,
                'target_class' => 'Address\Entity\City',
                'property' => 'name',
                'display_empty_item' => true,
                'empty_item_label' => $this->translate('Selecione...'),
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('id' => 'ASC'),
                    )
                ),
                'label' => $this->translate('Cidade: *'),
                'column-size' => 'sm-4',
                'label_attributes' => array('class' => 'col-sm-2 input-sm')
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
                /*
                 * Esse componente tem a função de obedecer a mudança de um determinado campo da tabela
                 * A tabela pai (master field) deve ter relação com a tabela filho (Referenciado nesse campo atual)
                 */
                'component' => 'join-select',
                /*
                master_field = É o campo dessa mesma tabela que ao ser alterada muda esta
                fk_table = É a tabela filha deve ser passado o nome da tabela do apigility
                fk_field = É o campo da tabela filha que é ligada com a tabela pai
                father_type = O tipo do campo pai é input ou select?
                */
                'component_params' => '{
                "master_field" : "state",
                    "fk_table" : "city",
                    "fk_field" : "state",
                    "father_type" : "select",
                    "placeholder" : "Selecione o estado primeiro"
                }'
            )
        ));

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
