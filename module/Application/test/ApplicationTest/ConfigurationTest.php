<?php

namespace ApplicationTest;

class ConfigurationTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function productionProperties() {
        putenv('APPLICATION_ENV=production');
        $config = include __DIR__ . '/../../../../config/application.config.php.dist';

        $sm = new \Zend\ServiceManager\ServiceManager(new \Zend\Mvc\Service\ServiceManagerConfig());
        $sm->setService('ApplicationConfig', $config);
        $sm->get('ModuleManager')->loadModules();

        $loadedConfig = $sm->get('Configuration');
        $loadedAppConfig = $sm->get('ApplicationConfig');

        $this->assertEquals('apc', $loadedConfig['doctrine']['configuration']['orm_default']['metadata_cache']);
        $this->assertEquals('apc', $loadedConfig['doctrine']['configuration']['orm_default']['query_cache']);
        $this->assertEquals('apc', $loadedConfig['doctrine']['configuration']['orm_default']['result_cache']);
        $this->assertFalse($loadedConfig['doctrine']['configuration']['orm_default']['generate_proxies']);
        $this->assertTrue($loadedAppConfig['module_listener_options']['config_cache_enabled']);
        $this->assertTrue($loadedAppConfig['module_listener_options']['module_map_cache_enabled']);
    }

    /**
     * @test
     */
    public function developmentProperties() {
        putenv('APPLICATION_ENV=development');
        $config = include __DIR__ . '/../../../../config/application.config.php.dist';

        $sm = new \Zend\ServiceManager\ServiceManager(new \Zend\Mvc\Service\ServiceManagerConfig());
        $sm->shareByDefault(false);
        $sm->setService('ApplicationConfig', $config);
        $sm->get('ModuleManager')->loadModules();

        $loadedConfig = $sm->get('Configuration');
        $loadedAppConfig = $sm->get('ApplicationConfig');

        $this->assertEquals('array', $loadedConfig['doctrine']['configuration']['orm_default']['metadata_cache']);
        $this->assertEquals('array', $loadedConfig['doctrine']['configuration']['orm_default']['query_cache']);
        $this->assertEquals('array', $loadedConfig['doctrine']['configuration']['orm_default']['result_cache']);
        $this->assertTrue($loadedConfig['doctrine']['configuration']['orm_default']['generate_proxies']);
        $this->assertFalse($loadedAppConfig['module_listener_options']['config_cache_enabled']);
        $this->assertFalse($loadedAppConfig['module_listener_options']['module_map_cache_enabled']);
    }

}