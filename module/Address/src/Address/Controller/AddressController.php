<?php

namespace Address\Controller;

use Base\Controller\CrudController;

class AddressController extends CrudController
{
    protected $route;

    public function __construct() 
    {
        $this->table = 'Address';
        $this->entity = 'Address\Entity\Address' ;
        $this->service = 'Address\Service\\'.$this->table ;
        $this->form = 'Address\Form\\'.$this->table ;
        $this->controller = "address";
        $this->route = "address/default";

        $this->title = "Endereços";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa-fw fa fa-bullhorn',
            'route' => $this->route,
            'controller' => $this->controller,
            'actions' => array(
                'enable' =>true,
                'defaults' => array(
                    'edit' => array(
                        'enable' => true,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-edit',
                        'title' => 'Editar',
                        'authorize' => false
                    ),
                    'delete' => array(
                        'enable' => true,
                        'class' => 'btn btn-danger decision',
                        'icon' => 'fa fa-trash',
                        'title' => 'Excluir',
                        'authorize' => false
                    ),
                    'view' => array(
                        'enable' => false,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-eye',
                        'title' => 'Visualizar'
                    ),
                ),
            ),
            'fields' => array(
                'id'=>array(
                    'label' => 'Código',
                    'list' => true,
                ),
                'user'=>array(
                    'label' => 'Usuário',
                    'list' => true,
                ),
                'address'=>array(
                    'label' => 'Logradouro',
                    'list' => true,
                ),
                'number'=>array(
                    'label' => 'Número',
                    'list' => true,
                ),
                'neighborhood'=>array(
                    'label' => 'Bairro',
                    'list' => true,
                ),
                'zip_code'=>array(
                    'label' => 'CEP',
                    'list' => true,
                ),
                'city'=>array(
                    'label' => 'Cidade',
                    'list' => true,
                ),
                'state'=>array(
                    'label' => 'Estado',
                    'list' => true,
                ),
                'country'=>array(
                    'label' => 'País',
                    'list' => true,
                ),
            ),
            'filters' => array(
            )
        );
    }
}
