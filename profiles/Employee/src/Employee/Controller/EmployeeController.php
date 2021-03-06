<?php

namespace Employee\Controller;

use Base\Controller\CrudController;

class EmployeeController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Funcionários");
        $this->table = 'Employee';
        $this->entity = 'Register\Entity\User' ;
        $this->service = 'Register\Service\User' ;
        $this->form = 'Employee\Form\\'.$this->table ;
        $this->controller = "employee";
        $this->route = "employee/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-user',
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
                    'label' => 'Id',
                    'list' => true,
                ),
                'name'=>array(
                    'label' => 'Nome',
                    'list' => true,
                ),
                'email'=>array(
                    'label' => 'E-mail',
                    'list' => true,
                ),
                'document' => array(
                    'label' => 'Documento',
                    'list' => true
                )
            ),
            'filters' => array(
                'name' => array(
                    'label'     => 'Nome',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'email' => array(
                    'label'     => 'E-mail',
                    'type'      => 'texto',
                    'strategy'  => 'like', //exact
                    'column'    => 'col-md-12'
                ),
                'document' => array(
                    'label'     => 'Documento',
                    'type'      => 'custom',
                    'column'    => 'col-md-12',
                ),
                'active' => array(
                    'label'     => 'Ativo',
                    'type'      => 'custom',
                    'column'    => 'col-md-12',
                )
            )
        );
    }

    public function  indexAction($list = null)
    {
        $list = [];

        /**
         * @var \Register\Service\User $service
         */
        $service = $this->getServiceLocator()->get($this->service);
        $list = $service->canList($this->entity,'funcionario');

        return parent::indexAction($list); // TODO: Change the autogenerated stub
    }
}
