<?php
namespace CategoryTransaction;

$rotas = array(
    'routes' => array(
        'category-transaction' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin',
                'defaults' => array(
                    '__NAMESPACE__' => 'CategoryTransaction\Controller',
                    'controller' => 'Index',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/category-transaction[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                        'constraints' => array(
                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+',
                            'page' => '\d+',
                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'order' => 'ASC|DESC',
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                            'controller' => 'CategoryTransaction',
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
        )
    )
);

return array(
    'router' => $rotas,
    'controllers' => array(
        'invokables' => array(
            'CategoryTransaction\Controller\CategoryTransaction' => 'CategoryTransaction\Controller\CategoryTransactionController'
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
