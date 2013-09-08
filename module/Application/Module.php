<?php

namespace Application;

use DoctrineModule\Service\DriverFactory;
use DoctrineModule\Service\EventManagerFactory;
use DoctrineORMModule\Service\ConfigurationFactory;
use DoctrineORMModule\Service\DBALConnectionFactory;
use DoctrineORMModule\Service\EntityManagerFactory;
use DoctrineORMModule\Service\EntityResolverFactory;
use Exception;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, ServiceProviderInterface {

    public function onBootstrap(EventInterface $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'checkConfiguration'));
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

    public function checkConfiguration() {
        if (!getenv('APPLICATION_ENV')) {
            throw new Exception('APPLICATION_ENV is not set. Refusing to run!');
        }
        if (!in_array(getenv('APPLICATION_ENV'), array('production', 'development'))) {
            throw new Exception("APPLICATION_ENV must be either 'production' or 
        'development'! Detected '" . getenv('APPLICATION_ENV') . "'");
        }
    }

}