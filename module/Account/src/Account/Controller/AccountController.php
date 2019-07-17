<?php

namespace Account\Controller;

use Base\Controller\CrudController;

class AccountController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Contas Bancárias");
        $this->table = 'Account';
        $this->entity = 'Account\Entity\\'.$this->table ;
        $this->service = 'Account\Service\\'.$this->table ;
        $this->form = 'Account\Form\\'.$this->table ;
        $this->controller = "account";
        $this->route = "account/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-layout-cta-left',
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
                'user'=>array(
                    'label' => $this->translate('Usuário'),
                    'list' => true,
                ),
                'holder'=>array(
                    'label' => $this->translate('Titular da Conta'),
                    'list' => true,
                ),
                'bank'=>array(
                    'label' => $this->translate('Banco'),
                    'list' => true,
                ),
                'agency'=>array(
                    'label' => $this->translate('Agência'),
                    'list' => true,
                ),
                'accountNumber'=>array(
                    'label' => $this->translate('Número da Conta'),
                    'list' => true,
                ),
                'type'=>array(
                    'label' => $this->translate('Tipo'),
                    'list' => true,
                )
            ),
            'filters' => array(
                'user' => array(
                    'label'     => 'Usuário',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'bank' => array(
                    'label'     => 'Banco',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'agency' => array(
                    'label'     => 'Agência',
                    'type'      => 'texto',
                    'strategy'  => 'exact', //exact
                    'column'    => 'col-md-12'
                ),
                'account-number' => array(
                    'label'     => 'Número da Conta',
                    'type'      => 'texto',
                    'strategy'  => 'exact', //exact
                    'column'    => 'col-md-12'
                ),
                'cnpj' => array(
                    'label'     => 'CNPJ',
                    'type'      => 'texto',
                    'strategy'  => 'exact', //exact
                    'column'    => 'col-md-12'
                ),
                'type' => array(
                    'label'     => 'Tipo de Conta',
                    'type'      => 'select',
                    'column'    => 'col-md-12',
                )
            )
        );
    }
}
