<?php

namespace Application\Controller\Factory;

use Application\Controller\ConsoleController;
use Doctrine\ORM\Tools\SchemaTool;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Console implements FactoryInterface {

    public function createService(ServiceLocatorInterface $services) {
        $serviceLocator = $services->getServiceLocator();

        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $tool = new SchemaTool($em);

        $controller = new ConsoleController;
        $controller->setEntityManager($em);
        $controller->setSchemaTool($tool);
        return $controller;
    }
}