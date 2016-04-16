<?php

namespace Debug;

use Zend\EventManager\Event;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;

class Module   {

//    public function getConfig() {
//        return include __DIR__ . '/config/module.config.php';
//    }
//
//    public function getAutoloaderConfig() {
//        return array(
//            'Zend\Loader\StandardAutoloader' => array(
//                'namespaces' => array(
//                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
//                ),
//            ),
//        );
//    }

    public function init(ModuleManager $moduleManager) {
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach(ModuleEvent::EVENT_LOAD_MODULES_POST, array($this, 'loadedModulesInfo'));
    }

    public function loadedModulesInfo(Event $event) {
        $moduleManager = $event->getTarget();
        $loadedModules = $moduleManager->getLoadedModules();
        error_log(var_export($loadedModules, true));
    }

}
