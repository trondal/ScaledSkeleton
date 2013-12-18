<?php

namespace Application;

return array(
    'view_manager' => array(
        'display_not_found_reason' => false,
        'display_exceptions' => false,
        'exception_template' => 'error',
        'not_found_template' => '404',
        'template_map' => array(
            'error' => __DIR__ . '/../../module/Application/view/error/error.phtml', // <-- system wide error template
            '404' => __DIR__ . '/../../module/Application/view/error/404.phtml',  // <-- system wide 404 template
            'layout/layout' => __DIR__ . '/../../module/Application/view/layout/application.phtml' // <-- error layout
        )
    ),
    'doctrine' => array(
        'configuration' => array(
            'orm_app' => array(
                'metadata_cache' => 'apc',
                'query_cache' => 'apc',
                'result_cache' => 'apc',
                'generate_proxies' => false,
            )
        ),
        'driver' => array(
            'app_driver' => array(
                'cache' => 'apc',
            )
        )
    )
);