<?php
namespace Address;

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
                'Address\Form\Address' => function ($sm){
                    return new Form\Address($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Address\Form\City' => function ($sm){
                    return new Form\City($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Address\Form\State' => function ($sm){
                    return new Form\State($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Address\Form\Country' => function ($sm){
                    return new Form\Country($sm->get('Doctrine\ORM\EntityManager'));
                },
                /**************/
                /** SERVICES **/
                /**************/
                'Address\Service\Address' => function ($sm)
                {
                    return new Service\Address($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Address\Service\City' => function ($sm)
                {
                    return new Service\City($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Address\Service\State' => function ($sm)
                {
                    return new Service\State($sm->get('Doctrine\ORM\EntityManager'));
                },
                'Address\Service\Country' => function ($sm)
                {
                    return new Service\Country($sm->get('Doctrine\ORM\EntityManager'));
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
