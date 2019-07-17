<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //Attach render errors
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, function($e)  {
            if ($e->getParam('exception')) {
                $this->exception( $e->getParam('exception') ) ; //Custom error render function.
            }
        } );
        //Attach dispatch errors
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function($e)  {
            if ($e->getParam('exception')) {
                $this->exception( $e->getParam('exception') ) ;//Custom error render function.
            }
        } );
    }

    public function exception($e) {
        echo "<span style='font-family: courier new; padding: 2px 5px; background:red; color: white;'> " . $e->getMessage() . '</span><br/>' ;
        echo "<pre>" . $e->getTraceAsString() . '</pre>' ;
    }

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
}
