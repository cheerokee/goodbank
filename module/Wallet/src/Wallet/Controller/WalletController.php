<?php

namespace Wallet\Controller;

use Base\Controller\CrudController;

class WalletController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Carteiras");
        $this->table = 'Wallet';
        $this->entity = 'Wallet\Entity\\'.$this->table ;
        $this->service = 'Wallet\Service\\'.$this->table ;
        $this->form = 'Wallet\Form\\'.$this->table ;
        $this->controller = "wallet";
        $this->route = "wallet/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-wallet',
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
                'account'=>array(
                    'label' => $this->translate('Número da Conta'),
                    'list' => true,
                ),
                'user'=>array(
                    'label' => $this->translate('Usuário'),
                    'list' => true,
                ),
                'activeStr'=>array(
                    'label' => $this->translate('Ativo'),
                    'list' => true,
                ),
            ),
            'filters' => array(
                'user' => array(
                    'label'     => 'Usuário',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'account' => array(
                    'label'     => 'Nº da Carteira',
                    'type'      => 'texto',
                    'strategy'  => 'like', //exact
                    'column'    => 'col-md-12'
                ),
                'active' => array(
                    'label'     => 'Ativo',
                    'type'      => 'select',
                    'column'    => 'col-md-12',
                )
            )
        );
    }
}
