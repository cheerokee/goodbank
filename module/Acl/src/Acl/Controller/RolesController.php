<?php
namespace Acl\Controller;

use Base\Controller\CrudController;

class RolesController extends CrudController
{
    public function __construct()
    {
        $this->title = "Perfis";

        $this->entity       =   "Acl\Entity\Role";
        $this->service      =   "Acl\Service\Role";
        $this->form         =   "Acl\Form\Role";
        $this->controller   =   "roles";
        $this->route        =   "roles/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'fa-fw fa fa-share-alt-square',
            'route' => $this->route,
            'controller' => $this->controller,
            'actions' => array(
                'enable' =>true,
                'defaults' => array(
                    'edit' => array(
                        'enable' => true,
                        'authorize' => false,
                        'title' =>  'Editar',
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-edit'
                    ),
                    'delete' => array(
                        'enable' => true,
                        'authorize' => false,
                        'title' =>  'Excluir',
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
                'name'=>array(
                    'label' => 'Nome',
                    'list' => true,
                ),
                'parentName'=>array(
                    'label' => 'Herança',
                    'list' => true,
                ),
                'isAdminStr'=>array(
                    'label' => 'É Admin?',
                    'list' => true,
                ),
            ),
        );
    }

    public function indexAction($list = null)
    {
        return parent::indexAction($list); // TODO: Change the autogenerated stub
    }

    public function newAction($request = null, $form = null, $redirect = null)
    {
        return parent::newAction($request, $form, $redirect); // TODO: Change the autogenerated stub
    }

    public function testAction()
    {
        $acl = $this->getServiceLocator()->get('Acl\Permissions\Acl');

        echo $acl->isAllowed('Cliente','Logística','Visualizar')?'Permitido':'Negado';
        die;
    }
}
