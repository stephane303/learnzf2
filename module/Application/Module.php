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
use Zend\Mvc\Controller\ControllerManager;
use Application\Controller\IndexController;
use Zend\Log\Writer\FirePhp;
use Zend\Log\Logger;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $services = $e->getApplication()->getServiceManager();
        $dbAdapter = $services->get('database');
        \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($dbAdapter); 
        $e->getApplication()->getServiceManager()->get('logger')->info( 'Application:'.count($e->getApplication()->getServiceManager()->get('config')));
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
    

    public function getControllerConfig() {
        return array(
            'factories' => array(
                //Suppose one of our routes specifies
                //a controller named 'myController'
                'Application\Controller\Index' => function( ControllerManager $sm) {
                    return new IndexController(
                            $sm->getServiceLocator()->get('config'),
                            $sm->getServiceLocator()->get('logger')
                            );
                }));
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                // [..] other factories for other serivces left out
                'logger' => function() {
                    $writer = new FirePhp();
                    $logger = new Logger();
                    $logger->addWriter($writer);
                    return $logger;
                },
            ),
        );
    }    
   
}
