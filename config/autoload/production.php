<?php

namespace Application;

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'configuration' => 'orm_default',
                'eventmanager' => 'orm_default',
            )
        ),
        'configuration' => array(
            'orm_default' => array(
                'metadata_cache' => 'apc',
                'query_cache' => 'apc',
                'result_cache' => 'apc',
                'driver' => 'orm_default',
                'generate_proxies' => false,
                'proxy_dir' => sys_get_temp_dir(),
                'proxy_namespace' => 'DoctrineORMModule\Proxy',
                'filters' => array(),
            )
        ),
        'driver' => array(
            'app_default' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../../module/Application/src/Application/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array('Application\Entity' => 'app_default')
            )
        ),
        'entitymanager' => array(
            'orm_default' => array(
                'connection' => 'orm_default',
                'configuration' => 'orm_default'
            )
        ),
        'eventmanager' => array(
            'orm_default' => array()
        ),
        'entity_resolver' => array(
            'orm_default' => array()
        )
    )
);