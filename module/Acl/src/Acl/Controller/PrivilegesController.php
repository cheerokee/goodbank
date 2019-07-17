<?php

namespace Acl\Controller;

use Base\Controller\CrudController;

class PrivilegesController extends CrudController
{
    protected $route;

    public function __construct()
    {
        $this->title = "Privilégios";

        $this->table = 'Privilege';
        $this->entity = 'Acl\Entity\\'.$this->table ;
        $this->service = 'Acl\Service\\'.$this->table ;
        $this->form = 'Acl\Form\\'.$this->table ;
        $this->controller = "Privilege";
        $this->route = "privileges/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa-fw fa fa-share-alt-square',
            'route' => $this->route,
            'controller' => $this->controller,
            'actions' => array(
                'enable' =>true,
                'customs' => array(
                ),
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
                'role'=>array(
                    'label' => 'Perfis',
                    'list' => true,
                ),
                'resource'=>array(
                    'label' => 'Recurso',
                    'list' => true,
                ),
                'name'=>array(
                    'label' => 'Nome',
                    'list' => true,
                ),
            ),
        );
    }

    public function  indexAction($list = null)
    {
        return parent::indexAction($list); // TODO: Change the autogenerated stub
    }

    public function editAction($request = null)
    {
        return parent::editAction($request); // TODO: Change the autogenerated stub
    }

    public function newAction($request = null)
    {
        return parent::newAction($request); // TODO: Change the autogenerated stub
    }
}
