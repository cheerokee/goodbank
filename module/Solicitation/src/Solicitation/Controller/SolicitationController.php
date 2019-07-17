<?php

namespace Solicitation\Controller;

use Base\Controller\CrudController;

class SolicitationController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Solicitações de Aporte");
        $this->table = 'Solicitation';
        $this->entity = 'Solicitation\Entity\\'.$this->table ;
        $this->service = 'Solicitation\Service\\'.$this->table ;
        $this->form = 'Solicitation\Form\\'.$this->table ;
        $this->controller = "solicitation";
        $this->route = "solicitation/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-thought',
            'route' => $this->route,
            'controller' => $this->controller,
            'actions' => array(
                'enable' =>true,
                'customs' => array(
                    'cash-out-panel' => array(
                        'rota' => 'cash-out-panel',
                        'title' => 'Painel de Pagamento',
                        'enable' => true,
                        'class' => 'btn btn-warning',
                        'icon' => 'hs-admin-align-justify',
                        'group' => false,
                        'authorize' => false
                    ),
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
                    'label' => $this->translate('Id'),
                    'list' => true,
                ),
                'typeStr'=>array(
                    'label' => $this->translate('Tipo de Solicitação'),
                    'list' => true,
                ),
                'valueStr'=>array(
                    'label' => $this->translate('Valor'),
                    'list' => true,
                ),
                'user_plan'=>array(
                    'label' => $this->translate('Aporte'),
                    'list' => true,
                ),
                'closedStr'=>array(
                    'label' => $this->translate('Atendido?'),
                    'list' => true,
                ),
                'createdAtStr'=>array(
                    'label' => $this->translate('Data da Solicitação'),
                    'list' => true,
                ),
            ),
            'filters' => array(
                'user_plan' => array(
                    'label'     => 'Aporte',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'type' => array(
                    'label'     => 'Tipo de Solicitação',
                    'type'      => 'select',
                    'column'    => 'col-md-12'
                ),
                'closed' => array(
                    'label'     => 'Atendido?',
                    'type'      => 'select',
                    'column'    => 'col-md-12',
                ),
                'created_at' => array(
                    'label'     => 'Data',
                    'type'      => 'date',
                    'column'    => 'col-md-12'
                )
            )
        );
    }

    public function indexAction($list = null, $count = 10)
    {
        $list = $this->getEm()
                     ->getRepository('Solicitation\Entity\Solicitation')
                     ->findBy(array(),array(
                        'closed' => 'ASC'
                    ));

        return parent::indexAction($list, $count);
    }
}
