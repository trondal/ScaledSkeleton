<?php

namespace ApplicationTest;

class ConfigurationTest extends HttpControllerTestCase {

    protected $createDatabase = false;

    public function testDoctrineConnection() {
        try {
            $this->em->getConnection()->connect();
        } catch (\PDOException $e) {
            $this->assertTrue(false, 'Could not connect to database'. $e->getMessage());
        }
    }

}