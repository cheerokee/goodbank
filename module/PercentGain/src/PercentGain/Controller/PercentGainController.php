<?php

namespace PercentGain\Controller;

use Base\Controller\CrudController;

class PercentGainController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Percentuais de Ganho");
        $this->table = 'PercentGain';
        $this->entity = 'PercentGain\Entity\\'.$this->table ;
        $this->service = 'PercentGain\Service\\'.$this->table ;
        $this->form = 'PercentGain\Form\\'.$this->table ;
        $this->controller = "percent-gain";
        $this->route = "percent-gain/default";

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
                'valueStartStr'=>array(
                    'label' => $this->translate('Valor Inicial'),
                    'list' => true,
                ),
                'valueFinishStr'=>array(
                    'label' => $this->translate('Valor Final'),
                    'list' => true,
                ),
                'percentStr'=>array(
                    'label' => $this->translate('Percentual'),
                    'list' => true,
                ),
            )
        );
    }
}
