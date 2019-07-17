<?php

namespace Bank\Controller;

use Base\Controller\CrudController;

class BankController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Bancos");
        $this->table = 'Bank';
        $this->entity = 'Bank\Entity\\'.$this->table ;
        $this->service = 'Bank\Service\\'.$this->table ;
        $this->form = 'Bank\Form\\'.$this->table ;
        $this->controller = "bank";
        $this->route = "bank/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa fa-bank',
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
                'activeStr'=>array(
                    'label' => $this->translate('Ativo'),
                    'list' => true,
                ),
            )
        );
    }
}
