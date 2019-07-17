<?php
namespace Configuration;

class Module{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                /***********/
                /** FORMS **/
                /***********/
                'Configuration\Form\Configuration' => function ($sm)
                {
                    return new Form\Configuration($sm->get('Doctrine\ORM\EntityManager'));
                },
                /**************/
                /** SERVICES **/
                /**************/
                'Configuration\Service\Configuration' => function($sm) {
                    $service = new Service\Configuration(
                        $sm->get('Doctrine\ORM\EntityManager'),
                        $sm->get('Base\Mail\Transport'),
                        $sm->get('View')
                    );

                    $service->setConfigurationMail($sm->get('Config'));

                    return $service;
                },
            )
        );
    }

    public function getViewHelperConfig(){
        return array(
            'invokables' => array(
                'getConfiguration'  => __NAMESPACE__ . '\View\Helper\GetConfiguration'
            )
        );
    }
}
