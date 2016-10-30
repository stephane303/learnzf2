<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\IndexController;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\I18n\Translator\Resources;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $services = $e->getApplication()->getServiceManager();
        $dbAdapter = $services->get('database');
        GlobalAdapterFeature::setStaticAdapter($dbAdapter); 
        $e->getApplication()->getServiceManager()->get('logger')->info( 'Application:'.count($e->getApplication()->getServiceManager()->get('config')));
        

        $translator     = $services->get('MvcTranslator');
        
        $translator->addTranslationFilePattern(
            'phpArray',
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );

        $translator->addTranslationFilePattern(
               'phpArray',
               __DIR__ . '/language',
                '%s/test.php'
            );
        
        //AbstractValidator::setDefaultTranslator($translator);
        AbstractValidator::setDefaultTranslator($translator); 
               
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
                    
                    $sl = $sm->getServiceLocator();
                    return new IndexController(
                            $sl->get('config'),
                            $sl->get('logger'),
                            $sl->get('Doctrine\ORM\EntityManager'),
                            $sl->get('timer')
                            );
                }));
    }
       
   
}
