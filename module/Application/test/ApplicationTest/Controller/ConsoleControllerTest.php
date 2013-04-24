<?php

namespace ApplicationTest\Controller;

class ConsoleControllerTest extends \ApplicationTest\HttpControllerTestCase {

    /**
     * @test
     */
    public function dropcreateAction() {
        $controllerLoader = $this->sm->get('ControllerLoader');
        $consoleController = $controllerLoader->get('Application\Controller\Console');

        $toolMock = $this->getMockBuilder('Doctrine\ORM\Tools\SchemaTool')
                ->disableOriginalConstructor()
                ->getMock();
        $toolMock->expects($this->once())
                ->method('dropSchema')
                ->will($this->returnValue(true));
        $toolMock->expects($this->once())
                ->method('createSchema')
                ->will($this->returnValue(true));


        $factoryMock = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadataFactory')
                ->disableOriginalConstructor()
                ->getMock();
        $factoryMock->expects($this->once())
                ->method('getAllMetadata')
                ->will($this->returnValue(array()));
        $emMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
                ->disableOriginalConstructor()
                ->getMock();
        $emMock->expects($this->once())
                ->method('getMetadataFactory')
                ->will($this->returnValue($factoryMock));

        $consoleController->setEntityManager($emMock);
        $consoleController->setSchemaTool($toolMock);

        $consoleController->dropcreateAction();
    }

}