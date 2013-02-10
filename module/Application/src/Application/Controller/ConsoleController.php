<?php

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Zend\Mvc\Controller\AbstractActionController;

class ConsoleController extends AbstractActionController implements EntityManagerAware{

    /**
     * @var EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function dropcreateAction() {
        $tool = new SchemaTool($this->em);
        $metaData = $this->em->getMetadataFactory()->getAllMetadata();

        $tool->dropSchema($metaData);
        $tool->createSchema($metaData);

        return 'Done' . PHP_EOL;
    }
}