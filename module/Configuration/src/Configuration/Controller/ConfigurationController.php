<?php
namespace Configuration\Controller;

use Base\Controller\CrudController;

class ConfigurationController extends CrudController{
    public function __construct() {
        $this->title = "Configurações";
        $this->table = "Configuration";
        $this->entity = 'Configuration\Entity\\'.$this->table ;
        $this->service = 'Configuration\Service\\'.$this->table ;
        $this->form = 'Configuration\Form\\'.$this->table ;
        $this->controller = "configuration";
        $this->route = "configuration/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa fa-text',
            'route' => $this->route,
            'controller' => $this->controller,
            'actions' => array(
                'enable' =>true,
                'defaults' => array(
                    'edit' => array(
                        'enable' => true,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-edit',
                        'authorize' => false
                    ),
                    'delete' => array(
                        'enable' => true,
                        'class' => 'btn btn-danger decision',
                        'icon' => 'fa fa-trash'
                    ),
                    'view' => array(
                        'enable' => false,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-eye'
                    ),
                ),
            ),
            'fields' => array(
                'id'=>array(
                    'label' => 'Id',
                    'list' => true,
                ),
                'title'=>array(
                    'label' => $this->translate('Título'),
                    'list' => true,
                ),
                'chave'=>array(
                    'label' => $this->translate('Chave'),
                    'list' => true,
                ),
                'value'=>array(
                    'label' => $this->translate('Valor'),
                    'list' => true,
                ),
                'editableStr'=>array(
                    'label' => $this->translate('Editável pelo Administrador'),
                    'list' => true,
                ),
            ),
        );
    }

    public function indexAction($list = null, $count = 10)
    {
        return parent::indexAction($list, $count);
    }
}
