<?php
namespace UserPlan;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

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
                'UserPlan\Form\UserPlan' => function ($sm){
                    return new Form\UserPlan($sm->get('Doctrine\ORM\EntityManager'));
                },
                'UserPlan\Service\UserPlan' => function($sm) {
                    $service = new Service\UserPlan($sm->get('Doctrine\ORM\EntityManager'),
                                    $sm->get('Base\Mail\Transport'),
                                    $sm->get('View'));

                    $service->setConfigurationMail($sm->get('Config'));

                    return $service;
                },
                'Base\Mail\Transport' => function($sm) {
                    $config = $sm->get('Config');

                    $transport = new SmtpTransport;
                    $options = new SmtpOptions($config['mail']);
                    $transport->setOptions($options);

                    return $transport;
                },
            )
        );
    }

    public function getViewHelperConfig(){
        return array(
            'invokables' => array(
            )
        );
    }
}
