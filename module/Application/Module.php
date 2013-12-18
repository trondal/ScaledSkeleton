<?php

namespace Application;

use DoctrineModule\Service\DriverFactory;
use DoctrineModule\Service\EventManagerFactory;
use DoctrineORMModule\Service\ConfigurationFactory;
use DoctrineORMModule\Service\DBALConnectionFactory;
use DoctrineORMModule\Service\EntityManagerFactory;
use DoctrineORMModule\Service\EntityResolverFactory;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, ServiceProviderInterface {

    public function onBootstrap(EventInterface $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // Fork of EpdModuleLayout, except this also handles subnamespaces
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            
            $pos = strpos($controllerClass, 'Controller');
            $moduleNamespace = substr($controllerClass, 0, $pos -1);

            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]);
            }
        }, 100);

    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'doctrine.entitymanager.orm_app' => new EntityManagerFactory('orm_app'),
                'doctrine.connection.orm_app' => new DBALConnectionFactory('orm_app'),
                'doctrine.configuration.orm_app' => new ConfigurationFactory('orm_app'),
                'doctrine.driver.orm_app' => new DriverFactory('orm_app'),
                'doctrine.eventmanager.orm_app' => new EventManagerFactory('orm_app'),
                'doctrine.entity_resolver.orm_app' => new EntityResolverFactory('orm_app'),
            )
        );
    }
}