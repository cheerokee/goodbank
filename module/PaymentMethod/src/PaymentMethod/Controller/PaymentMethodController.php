<?php

namespace PaymentMethod\Controller;

use Base\Controller\CrudController;

class PaymentMethodController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Formas de Pagamento");
        $this->table = 'PaymentMethod';
        $this->entity = 'PaymentMethod\Entity\\'.$this->table ;
        $this->service = 'PaymentMethod\Service\\'.$this->table ;
        $this->form = 'PaymentMethod\Form\\'.$this->table ;
        $this->controller = "payment-method";
        $this->route = "payment-method/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-money',
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
