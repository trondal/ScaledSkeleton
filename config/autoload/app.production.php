<?php

namespace Application;

return array(
    'doctrine' => array(
        'configuration' => array(
            'orm_app' => array(
                'metadata_cache' => 'apc',
                'query_cache' => 'apc',
                'result_cache' => 'apc',
                'generate_proxies' => false,
            )
        )
    )
);