<?php

namespace CategoryTransaction\Controller;

use Base\Controller\CrudController;

class CategoryTransactionController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Categorias de Transação");
        $this->table = 'CategoryTransaction';
        $this->entity = 'CategoryTransaction\Entity\\'.$this->table ;
        $this->service = 'CategoryTransaction\Service\\'.$this->table ;
        $this->form = 'CategoryTransaction\Form\\'.$this->table ;
        $this->controller = "category-transaction";
        $this->route = "category-transaction/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-menu-alt',
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
                'code'=>array(
                    'label' => $this->translate('Código'),
                    'list' => true,
                )
            )
        );
    }
}
