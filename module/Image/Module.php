<?php
namespace Image;

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
                'Image\Form\Image' => function ($sm){
                    return new Form\Image($sm->get('Doctrine\ORM\EntityManager'));
                },
                /**************/
                /** SERVICES **/
                /**************/
                'Image\Service\Image' => function ($sm)
                {
                    return new Service\Image($sm->get('Doctrine\ORM\EntityManager'));
                }
            )
        );
    }

    public function getViewHelperConfig(){
        return array();
    }
}
