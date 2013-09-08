Doctrine 2 Config Howto
=======================

Creating a new module with Doctrine 2
=====================================

1. Create to following files in the new module:
    config/local.dist.php
    config/module-name.development.dist.php
    config/module-name.production.dist.php
    config/module.config.php


1. Config/local.dist.php: 
    `'doctrine' => array(
        'connection' => array(
            'orm_module_name' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => array(
                    'host' => '',
                    'port' => '',
                    'user' => '',
                    'password' => '',
                    'dbname' => ''
                )
            )
        )
    )
Do NOT add the username/password in this file!

2. Config/module-name.development.dist.php:
    `'doctrine' => array(
        'configuration' => array(
            'orm_module_name' => array(
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'generate_proxies' => true,
            )
        ),
        'driver' => array(
            'module_name_driver' => array(
                'cache' => 'array',
            )
        )
    ),`

3. Config/module-name.application.dist.php:
    `'doctrine' => array(
        'configuration' => array(
            'orm_module_name' => array(
                'metadata_cache' => 'apc',
                'query_cache' => 'apc',
                'result_cache' => 'apc',
                'generate_proxies' => false,
            )
        ),
        'driver' => array(
            'module_name_driver' => array(
                'cache' => 'apc',
            )
        )
    ),`

4. Config/module.config.php:
    `'doctrine' => array(
        'entitymanager' => array(
            'orm_module_name' => array(
                'connection' => 'orm_module_name',
                'configuration' => 'orm_module_name'
            )
        ),
        'configuration' => array(
            'orm_module_name' => array(
                'driver' => 'orm_module_name',
                'proxy_dir' => sys_get_temp_dir(),
                'proxy_namespace' => 'DoctrineORMModule\Proxy',
                'filters' => array()
            )
        ),
        'driver' => array(
            'module_name_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(
                    __DIR__ . '/../../module/Application/src/Application/Entity'
                )
            ),
            'orm_module_name' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => array(
                    'Application\Entity' => 'module_name_driver'
                )
            )
        )
    )`

5. In the modules Module.php file, add the service-factories in getServiceConfig():
`'factories' => array(
                'doctrine.entitymanager.orm_module_name' => new EntityManagerFactory('orm_module_name'),
                'doctrine.connection.orm_module_name' => new DBALConnectionFactory('orm_module_name'),
                'doctrine.configuration.orm_module_name' => new ConfigurationFactory('orm_module_name'),
                'doctrine.driver.orm_module_name' => new DriverFactory('orm_module_name'),
                'doctrine.eventmanager.orm_module_name' => new EventManagerFactory('orm_module_name'),
                'doctrine.entity_resolver.orm_module_name' => new EntityResolverFactory('orm_module_name'),
            )`


6. Copy the doctrine-key content of local.dist.php into /configs/autoload/local.php. Set the username/password/port/host/dbname.
7. Copy the files module-name.development and module-name.production.php to /config/autoload/*. Rename the files to remove the 'dist' name.

8. In /bin run "php doctrine-module orm_module_name" to verify that the objectmanager is reachable. If it is, you have the 
CLI power at your disposal, as long as you add the objectmanager name as the first parameter.

9. As a final check, verify that the doctrine cache is set correctly:

`$config = $this->getServiceManager()->get('Config');
echo '<pre>';
print_r($config['doctrine']);
exit;

Depending of your APPLICATION_ENV, the cache keys should vary between array and apc. DO NOT set the objectmanager in production 
without verifying that 'array' is NOT set as the meta, query, result, driver cache!!!!!!!! 
Doctrine supports xcache, apc, memcache and others as cache machines. 
**** Array cache will slow Doctrine down significally on production ***



