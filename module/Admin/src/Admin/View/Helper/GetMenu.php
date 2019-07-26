<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class GetMenu extends AbstractHelper implements ServiceLocatorAwareInterface{
    protected $serviceLocator,$em;

    protected $authService;

    public function getAuthService() {

        return $this->authService;
    }


    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param mixed $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    public function __invoke() {
        $sessionStorage = new SessionStorage('User');
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);
        return array(
            'panel-investiment' => array(
                'titulo'    =>  'Invista',
                'active'    => true,
                'icon' => 'hs-admin-layout-media-center-alt',
                'rota' => '/admin/panel-investiment',
            ),
            'my-investiment' => array(
                'titulo'    =>  'Meus Investimentos',
                'active'    => true,
                'icon' => 'hs-admin-money',
                'rota' => '/admin/my-investiment',
            ),
            'users' => array(
                'titulo'    =>  'Usuários',
                'active'    => true,
                'icon' => 'hs-admin-user',
                'itens'     =>  array(
                    'user' => array(
                        'icon' => 'hs-admin-user',
                        'titulo' => 'Usuários',
                        'rota' => '/admin/user',
                        'authorize' => false,
                    ),
                    'administrator' => array(
                        'icon' => 'hs-admin-user',
                        'titulo' => 'Administradores',
                        'rota' => '/admin/administrator',
                        'authorize' => false,
                    ),
                    'employee' => array(
                        'icon' => 'hs-admin-user',
                        'titulo' => 'Funcionários',
                        'rota' => '/admin/employee',
                        'authorize' => false,
                    ),
                    'customer' => array(
                        'icon' => 'hs-admin-user',
                        'titulo' => 'Clientes',
                        'rota' => '/admin/customer',
                        'authorize' => false,
                    )
                )
            ),
            'cadastros' => array(
                'titulo'    =>  'Cadastros',
                'active'    => true,
                'icon' => 'hs-admin-layout-grid-3',
                'itens'     =>  array(
                    'user-plan' => array(
                        'titulo' => 'Planos dos Usuários',
                        'icon' => 'hs-admin-layout-list-thumb',
                        'rota' => '/admin/user-plan',
                        'authorize' => false,
                    ),
                    'transaction' => array(
                        'titulo' => 'Transações',
                        'icon' => 'hs-admin-exchange-vertical',
                        'rota' => '/admin/transaction',
                        'authorize' => false,
                    ),
                    'bank' => array(
                        'titulo' => 'Bancos',
                        'icon' => 'fa fa-bank',
                        'rota' => '/admin/bank',
                        'authorize' => false,
                    ),
                    'account' => array(
                        'titulo' => 'Contas Bancárias',
                        'icon' => 'hs-admin-layout-cta-left',
                        'rota' => '/admin/account',
                        'authorize' => false,
                    ),
                    'plan' => array(
                        'titulo' => 'Planos',
                        'icon' => 'hs-admin-package',
                        'rota' => '/admin/plan',
                        'authorize' => false,
                    ),
                    'cycle' => array(
                        'titulo' => 'Ciclos',
                        'icon' => 'hs-admin-calendar',
                        'rota' => '/admin/cycle',
                        'authorize' => false,
                    ),
                    'category-transaction' => array(
                        'titulo' => 'Categorias de Transação',
                        'icon' => 'hs-admin-menu-alt',
                        'rota' => '/admin/category-transaction',
                        'authorize' => false,
                    ),
                    'payment-method' => array(
                        'titulo' => 'Formas de Pagamento',
                        'icon' => 'hs-admin-money',
                        'rota' => '/admin/payment-method',
                        'authorize' => false,
                    ),
                    'wallet' => array(
                        'titulo' => 'Carteiras',
                        'icon' => 'hs-admin-wallet',
                        'rota' => '/admin/wallet',
                        'authorize' => false,
                    ),
                    'address' => array(
                        'titulo' => 'Endereços',
                        'icon' => 'hs-admin-location-pin',
                        'rota' => '/admin/address',
                        'authorize' => false,
                    ),
                    'percent-gain' => array(
                        'titulo' => 'Percentuais de Ganho',
                        'icon' => 'hs-admin-money',
                        'rota' => '/admin/percent-gain',
                        'authorize' => false,
                    ),
                    'solicitation' => array(
                        'titulo' => 'Solicitações de Aporte',
                        'icon' => 'hs-admin-thought',
                        'rota' => '/admin/solicitation',
                        'authorize' => false,
                    ),
                ),
            ),
            'authorize' => array(
                'titulo'    =>  'Autorização',
                'active'    => false,
                'icon' => 'hs-admin-lock',
                'itens'     =>  array(
                    'painel-authorize' => array(
                        'titulo' => 'Painel de Autorização',
                        'icon' => 'hs-admin-lock',
                        'rota' => '/admin/panel-authorize',
                        'authorize' => false,
                    ),
                    'roles' => array(
                        'titulo' => 'Perfis',
                        'icon' => 'hs-admin-id-badge',
                        'rota' => '/admin/roles',
                        'authorize' => false,
                    ),
                    'resources' => array(
                        'titulo' => 'Recursos',
                        'icon' => 'hs-admin-layers',
                        'rota' => '/admin/resources',
                        'authorize' => false,
                    ),
                    'actions' => array(
                        'titulo' => 'Ações',
                        'icon' => 'hs-admin-layers-alt',
                        'rota' => '/admin/actions',
                        'authorize' => false,
                    )
                ),
            ),
            'configuracoes' => array(
                'titulo'    =>  'Configurações',
                'active'    => false,
                'icon' => 'hs-admin-settings',
                'itens'     =>  array(
                    'configuration' => array(
                        'titulo' => 'Configuração Geral do Sistema',
                        'icon' => 'hs-admin-settings',
                        'rota' => '/admin/configuration',
                        'authorize' => false,
                    )
                ),
            ),
            'site' => array(
                'titulo'    =>  'Site',
                'active'    => true,
                'icon' => 'fa fa-desktop',
                'rota' => '/',
            )
        );
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
