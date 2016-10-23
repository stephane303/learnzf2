<?php

namespace Debug;

use Debug\Service\Timer;
use Exception;
use Zend\EventManager\Event;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\Log\Writer\FirePhp;
use Zend\Log\Logger;

class Module {
    
    private $logger;
   
    
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function init(ModuleManager $moduleManager) {
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach(ModuleEvent::EVENT_LOAD_MODULES_POST, array($this, 'loadedModulesInfo'));
        $shared = $eventManager->getSharedManager();
        $shared->attach('Zend\Mvc\Application', MvcEvent::EVENT_BOOTSTRAP, array($this, 'startTimer'));
        $shared->attach('Zend\Mvc\Application', MvcEvent::EVENT_FINISH, array($this, 'stopTimer'), 0);
        $shared->attach('*', '*', array($this, 'allEvents'));
    }

    public function loadedModulesInfo(Event $event) {
        $moduleManager = $event->getTarget();
        $loadedModules = $moduleManager->getLoadedModules();
        error_log(var_export($loadedModules, true));
    }

    public function allEvents(Event $event) {

        //echo get_class($event) . ':' . $event->getName() . '<br>';
        
    }

    public function startTimer(MvcEvent $event) {
        /* @var $target MvcEvent */

        $sm = $event->getApplication()->getServiceManager();
        /* @var $timer Timer */
        $timer = $sm->get('timer');
        $timer->start('test');
    }

    public function stopTimer(MvcEvent $event) {
        $eventManager = $event->getApplication()->getEventManager();
        $sm = $event->getApplication()->getServiceManager();
        $timer = $sm->get('timer');
        $this->logger->info('Timer:'. $timer->stop('test'));
        $this->logger->info($event->getApplication()->getServiceManager()->get('config'));
    }

    public function onBootstrap(MvcEvent $e) {
        $this->logger =  $e->getApplication()->getServiceManager()->get('logger');
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));

        $eventManager->attach(MvcEvent::EVENT_RENDER, array($this, 'addDebugOverlay'), 100);
        $this->logger->info( 'Debug:'.count($e->getApplication()->getServiceManager()->get('config')));

    }

    public function handleError(MvcEvent $event) {
        $controller = $event->getController();
        $error = $event->getParam('error');
        $exception = $event->getParam('exception');
        $message = sprintf('Error dispatching controller "%s". Error was: "%s"', $controller, $error);
        if ($exception instanceof Exception) {
            $message .= ', Exception(' . $exception->getMessage() . '): ' .
                    $exception->getTraceAsString();
        }

        error_log($message);
    }
    
    public function addDebugOverlay(Event $event){
         $viewModel = $event->getViewModel();
         
         if (!is_a($viewModel, 'Zend\View\Model\JsonModel')){
         
            $sidebarView = new ViewModel();
            $sidebarView->setTemplate('debug/layout/sidebar');
            $sidebarView->addChild($viewModel, 'content');

            $event->setViewModel($sidebarView);  
         }
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
