<?php
namespace Register;

$rotas = array(
    'routes' => array(
        'home' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/',
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'Auth',
                    'action' => 'index'
                )
            )
        ),
        'user-auth' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/auth',
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'Auth',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/[:controller[/:action[/:id]]]',
                        'constraints' => array(
                            'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+'
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'Register\Controller',
                            'controller' => 'auth'
                        )
                    )
                ),
                'paginator' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/[:controller[/page/:page]]',
                        'constraints' => array(
                            'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'page' => '\d+'
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'Register\Controller',
                            'controller' => 'auth'
                        )
                    )
                )
            )
        ),
        'user-logout' => array(
            'type' => 'Literal',
            'options' => array(
                'route'=>'/auth/logout',
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'Auth',
                    'action' => 'logout'
                )
            )
        ),
        'lostpassword' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/auth/lostpassword',
                'defaults' => array(
                    '__NAMESPACE__'=>'Register\Controller',
                    'controller' => 'Auth',
                    'action' => 'lostpassword'
                )
            )
        ),
        'mail-lostPassword' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/mailer/mail-lostPassword',
                'defaults' => array(
                    'controller' => 'Register\Controller\AuthController',
                    'action' => 'lostpassword'
                )
            )
        ),
        'user' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin',
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'Index',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/user[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                        'constraints' => array(
                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+',
                            'page' => '\d+',
                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'order' => 'ASC|DESC',
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                            'controller' => 'User',
                            'action' => 'index'
                        )
                    )
                ),
                'paginator' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/[/:controller[/page/:page]]',
                        'constraints' => array(
                            'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'page' => '\d+'
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                            'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        )
                    )
                )
            )
        ),
        'user-role' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/user-role[/:id]',
                'constraints' => array(
                    'id' => '\d+'
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'User',
                    'action' => 'profile'
                )
            )
        ),
        'bank-account' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin/bank-account',
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'BankAccount',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/[:controller[/:action[/:id]]]',
                        'constraints' => array(
                            'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+'
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'Register\Controller',
                            'controller' => 'bank-account'
                        )
                    )
                ),
                'paginator' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/[:controller[/page/:page]]',
                        'constraints' => array(
                            'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'page' => '\d+'
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'Register\Controller',
                            'controller' => 'bank-account'
                        )
                    )
                )
            )
        ),
        'bank-account-edit' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/bank-account/edit[/:id]',
                'constraints' => array(
                    'id' => '\d+'
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'BankAccount',
                    'action' => 'edit'
                )
            )
        ),
        'user-register' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/register',
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'Auth',
                    'action' => 'register',
                )
            )
        ),
        'user-activate' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/register/activate[/:key]',
                'defaults' => array(
                    'controller' => 'Register\Controller\Index',
                    'action' => 'activate'
                )
            )
        ),
        'user-view' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/admin/user-view[/:id]',
                'constraints' => array(
                    'id' => '\d+'
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'User',
                    'action' => 'user-view'
                )
            )
        ),
        'resend-confirm' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/resend-confirm',
                'defaults' => array(
                    '__NAMESPACE__' => 'Register\Controller',
                    'controller' => 'Auth',
                    'action' => 'resend-confirm',
                )
            )
        ),
    )
);

return array(
    'router' => $rotas,
    'controllers' => array(
        'invokables' => array(
            'Register\Controller\Index' => 'Register\Controller\IndexController',
            'Register\Controller\User' => 'Register\Controller\UserController',
            'Register\Controller\Auth' => 'Register\Controller\AuthController',
            'Register\Controller\BankAccount' => 'Register\Controller\BankAccountController'
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'filter-user'     => __DIR__ . '/../view/partials/filter-user.phtml',
            'error/404'         => __DIR__ . '/../view/error/404.phtml',
            'error/index'       => __DIR__ . '/../view/error/index.phtml',
            'form-account'      => __DIR__ . '/../view/register/user/partials/form-account.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);
