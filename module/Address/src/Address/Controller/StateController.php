<?php

namespace Address\Controller;

use Base\Controller\CrudController;

class StateController extends CrudController
{
    protected $route;

    public function __construct() 
    {
        $this->table = 'State';
        $this->entity = 'Address\Entity\State' ;
        $this->service = 'Address\Service\\'.$this->table ;
        $this->form = 'Address\Form\\'.$this->table ;
        $this->controller = "state";
        $this->route = "state/default";

        $this->title = "Estados";

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
                'uf'=>array(
                    'label' => 'Sigla',
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
