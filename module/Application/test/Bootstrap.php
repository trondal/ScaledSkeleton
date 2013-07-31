<?php

namespace ApplicationTest;

use RuntimeException;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

class Bootstrap {

    protected static $serviceManager;
    protected static $config;

    /**
     * Bootstrap the application.
     *
     * @return void
     */
    public static function init() {
        $config = include __DIR__ . '/../../../config/application.config.php.dist';
        static::initAutoloader();

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();

        static::$serviceManager = $serviceManager;
        static::$config = $config;

	require_once 'HttpControllerTestCase.php';
    }

    /**
     * Get application's servicemanager.
     *
     * @return ServiceManager
     */
    public static function getServiceManager() {
        return static::$serviceManager;
    }

    /**
     * Get application configuration array.
     *
     * @return array
     */
    public static function getConfig() {
        return static::$config;
    }

    /**
     * Initialize the Autoloader.
     *
     * @throws RuntimeException
     * @return void
     */
    protected static function initAutoloader() {
        $vendorPath = static::findParentPath('vendor');

        include $vendorPath . '/autoload.php';
        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    /**
     * Find parent path.
     *
     * @param string $path
     * @return boolean
     */
    protected static function findParentPath($path) {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir)
                return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }

}

\ApplicationTest\Bootstrap::init();