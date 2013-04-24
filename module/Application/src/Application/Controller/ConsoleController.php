<?php

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Zend\Mvc\Controller\AbstractActionController;

class ConsoleController extends AbstractActionController implements SchemaToolAware, EntityManagerAware {

    /**
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    protected $tool;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setSchemaTool(SchemaTool $tool) {
        $this->tool = $tool;
    }

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function dropcreateAction() {
        $metaDataFactory = $this->em->getMetadataFactory();
        $metaData = $metaDataFactory->getAllMetadata();

        $this->tool->dropSchema($metaData);
        $this->tool->createSchema($metaData);

        return 'Done' . PHP_EOL;
    }
}