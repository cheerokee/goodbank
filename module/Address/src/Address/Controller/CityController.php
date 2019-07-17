<?php

namespace Address\Controller;

use Base\Controller\CrudController;

class CityController extends CrudController
{
    protected $route;

    public function __construct() 
    {
        $this->table = 'City';
        $this->entity = 'Address\Entity\City' ;
        $this->service = 'Address\Service\\'.$this->table ;
        $this->form = 'Address\Form\\'.$this->table ;
        $this->controller = "city";
        $this->route = "city/default";

        $this->title = "Cidade";

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
                'name'=>array(
                    'label' => 'Nome',
                    'list' => true,
                ),
                'state'=>array(
                    'label' => 'Estado',
                    'list' => true,
                ),
            ),
            'filters' => array(
            )
        );
    }

    public function  indexAction($list = null)
    {
        return parent::indexAction($list);
    }

    public function editAction($request = null)
    {
        return parent::editAction($request);
    }

    public function newAction($request = null)
    {
        return parent::newAction($request);
    }
}
