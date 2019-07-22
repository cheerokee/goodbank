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
                ),
                'mainStr'=>array(
                    'label' => $this->translate('Principal?'),
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

    public function newAction($request = null, $form = null, $redirect = null)
    {
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data       = $request->getPost();
            $data_arr   = $data->toArray();
            if(isset($data_arr['main']) && $data_arr['main'] == 1){
                $db_accounts = $em->getRepository('Account\Entity\Account')->findByUser($data_arr['user']);
                if(!empty($db_accounts)){
                    foreach($db_accounts as $db_account){
                        $db_account->setMain(0);
                        $em->persist($db_account);
                        $em->flush();
                    }
                }
            }
        }

        return parent::newAction($request, $form, $redirect); // TODO: Change the autogenerated stub
    }

    public function editAction($request = null, $form = null, $redirect = null)
    {
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data       = $request->getPost();
            $data_arr   = $data->toArray();
            if(isset($data_arr['main']) && $data_arr['main'] == 1){
                $db_accounts = $em->getRepository('Account\Entity\Account')->findByUser($data_arr['user']);
                if(!empty($db_accounts)){
                    foreach($db_accounts as $db_account){
                        $db_account->setMain(0);
                        $em->persist($db_account);
                        $em->flush();
                    }
                }
            }
        }

        return parent::editAction($request, $form, $redirect); // TODO: Change the autogenerated stub
    }
}
