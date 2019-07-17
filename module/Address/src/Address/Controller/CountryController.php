<?php

namespace Address\Controller;

use Base\Controller\CrudController;

class CountryController extends CrudController
{
    protected $route;

    public function __construct() 
    {
        $this->table = 'Country';
        $this->entity = 'Address\Entity\Country' ;
        $this->service = 'Address\Service\\'.$this->table ;
        $this->form = 'Address\Form\\'.$this->table ;
        $this->controller = "country";
        $this->route = "country/default";

        $this->title = "Países";

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
                'abbreviation'=>array(
                    'label' => 'Abreviação',
                    'list' => true,
                )
            ),
            'filters' => array(
            )
        );
    }
}
