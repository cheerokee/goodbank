<?php

namespace Cycle\Controller;

use Base\Controller\CrudController;
use Doctrine\ORM\EntityManager;

class CycleController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Ciclos");
        $this->table = 'Cycle';
        $this->entity = 'Cycle\Entity\\'.$this->table ;
        $this->service = 'Cycle\Service\\'.$this->table ;
        $this->form = 'Cycle\Form\\'.$this->table ;
        $this->controller = "cycle";
        $this->route = "cycle/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-calendar',
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
                'month'=>array(
                    'label' => $this->translate('Mes'),
                    'list' => true,
                ),
                'year'=>array(
                    'label' => $this->translate('Ano'),
                    'list' => true,
                ),
                'statusStr'=>array(
                    'label' => $this->translate('Status'),
                    'list' => true,
                ),
            ),
            'filters' => array(
                'month' => array(
                    'label'     => 'Mes',
                    'type'      => 'select',
                    'column'    => 'col-md-12',
                ),
                'year' => array(
                    'label'     => 'Ano',
                    'type'      => 'texto',
                    'strategy'  => 'exact', //exact
                    'column'    => 'col-md-12'
                ),
                'status' => array(
                    'label'     => 'Status',
                    'type'      => 'select',
                    'column'    => 'col-md-12',
                )
            )
        );
    }

    public function indexAction($list = null, $count = 10)
    {
        /**
         * @var EntityManager $em
         */
        $em = $this->getEm();
        $list = $em->getRepository('Cycle\Entity\Cycle')->findBy(array(),array(
            'status' => 'ASC',
            'year' => 'DESC',
            'month' => 'DESC'
        ));

        return parent::indexAction($list, $count);
    }
}
