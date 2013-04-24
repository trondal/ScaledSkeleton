<?php

namespace ApplicationTest\Controller;

class IndexControllerTest extends \ApplicationTest\HttpControllerTestCase {

    /**
     * @test
     */
    public function indexAction() {
        $this->dispatch('http://subdomain.domain.tld');
        $this->assertActionName('index');
        $this->assertModuleName('application');
        $this->assertResponseStatusCode(200);
    }

}