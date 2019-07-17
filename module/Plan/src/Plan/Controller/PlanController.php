<?php

namespace Plan\Controller;

use Base\Controller\CrudController;

class PlanController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Planos");
        $this->table = 'Plan';
        $this->entity = 'Plan\Entity\\'.$this->table ;
        $this->service = 'Plan\Service\\'.$this->table ;
        $this->form = 'Plan\Form\\'.$this->table ;
        $this->controller = "plan";
        $this->route = "plan/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-package',
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
                    'label' => $this->translate('Id'),
                    'list' => true,
                ),
                'name'=>array(
                    'label' => $this->translate('Nome'),
                    'list' => true,
                ),
                'priceStr'=>array(
                    'label' => $this->translate('Preço'),
                    'list' => true,
                ),
                'activeStr'=>array(
                    'label' => $this->translate('Ativo'),
                    'list' => true,
                ),
            )
        );
    }
}
