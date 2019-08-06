<?php
namespace UserPlan;

$rotas = array(
    'routes' => array(
        'user-plan' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'Index',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/user-plan[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                        'constraints' => array(
                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+',
                            'page' => '\d+',
                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'order' => 'ASC|DESC',
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                            'controller' => 'UserPlan',
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
        'panel-investiment' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin/panel-investiment',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'panel-investiment'
                )
            )
        ),
        'my-investiment' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin/my-investiment',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'my-investiment'
                )
            )
        ),
        'contract-save' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/contract-save',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'contract-save'
                )
            )
        ),
        'balance' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/balance',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'balance'
                )
            )
        ),
        'comission' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/comission',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'comission'
                )
            )
        ),
        'send-cash-out' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/send-cash-out',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'send-cash-out'
                )
            )
        ),
        'send-rr' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/send-rr',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'send-rr'
                )
            )
        ),
        'cash-out-panel' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/cash-out-panel[/:id]',
                'constraints' => array(
                    'id' => '\d+'
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'cash-out-panel'
                )
            )
        ),
        'withdrawal' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/withdrawal',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'withdrawal'
                )
            )
        ),
        'renew' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/renew',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'renew'
                )
            )
        ),
        'rescue' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/rescue',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'rescue'
                )
            )
        ),
        'user-network' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/user-network',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'user-network'
                )
            )
        ),
        'apply-balance' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/apply-balance',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'apply-balance'
                )
            )
        ),
        'read-xls' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/read-xls',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'read-xls'
                )
            )
        ),
        'save-user-plan' => array(
            'type' => 'Segment',
            'options' => array(
                'route'=>'/admin/save-user-plan',
                'defaults' => array(
                    '__NAMESPACE__' => 'UserPlan\Controller',
                    'controller' => 'UserPlan',
                    'action' => 'save-user-plan'
                )
            )
        )
    )
);

return array(
    'router' => $rotas,
    'controllers' => array(
        'invokables' => array(
            'UserPlan\Controller\UserPlan' => 'UserPlan\Controller\UserPlanController'
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
            'error/404'         => __DIR__ . '/../view/error/404.phtml',
            'error/index'       => __DIR__ . '/../view/error/index.phtml'
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
