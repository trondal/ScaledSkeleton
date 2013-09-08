<?php

namespace Application;

return array(
    'view_manager' => array(
        'display_not_found_reason' => false,
        'display_exceptions' => false,
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