<?php

namespace Application;

return array(
    'doctrine' => array(
        'configuration' => array(
            'orm_app' => array(
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'generate_proxies' => true,
            )
        ),
    )
);