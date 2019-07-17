<?php
namespace Address;

$rotas = array(
    'routes' => array(
        'address' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin',
                'defaults' => array(
                    '__NAMESPACE__' => 'Address\Controller',
                    'controller' => 'Index',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/address[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                        'constraints' => array(
                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+',
                            'page' => '\d+',
                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'order' => 'ASC|DESC',
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                            'controller' => 'Address',
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
        'city' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin',
                'defaults' => array(
                    '__NAMESPACE__' => 'Address\Controller',
                    'controller' => 'Index',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/city[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                        'constraints' => array(
                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+',
                            'page' => '\d+',
                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'order' => 'ASC|DESC',
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                            'controller' => 'City',
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
        'state' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin',
                'defaults' => array(
                    '__NAMESPACE__' => 'Address\Controller',
                    'controller' => 'Index',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/state[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                        'constraints' => array(
                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+',
                            'page' => '\d+',
                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'order' => 'ASC|DESC',
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                            'controller' => 'State',
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
        'country' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/admin',
                'defaults' => array(
                    '__NAMESPACE__' => 'Address\Controller',
                    'controller' => 'Index',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'default' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/country[/:action[/:id]][/page/:page][/order_by/:order_by][/:order]',
                        'constraints' => array(
                            'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '\d+',
                            'page' => '\d+',
                            'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'order' => 'ASC|DESC',
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                            'controller' => 'Country',
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
            'Address\Controller\Address' => 'Address\Controller\AddressController',
            'Address\Controller\City' => 'Address\Controller\CityController',
            'Address\Controller\State' => 'Address\Controller\StateController',
            'Address\Controller\Country' => 'Address\Controller\CountryController',
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
