<?php

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'application' => array(
                'type' => 'Zend\Mvc\Router\Http\Hostname',
                'options' => array(
                    'route' => 'application.[:opt1.][:opt2.][:opt3.]:tld',
                    'defaults' => array(
                        '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                    )
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'index' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/',
                            'defaults' => array(
                                'controller' => __NAMESPACE__ .'\Controller\Index',
                                'action' => 'index',
                            )
                        )
                    )
                )
            )
        ),
    ),
    'service_manager' => array(
        'factories' => array()
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
                'text_domain' => __NAMESPACE__
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . '\Controller\Index' => __NAMESPACE__ .'\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/application.phtml',
            'application/layout' => __DIR__ . '/../view/layout/application.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'module_layouts' => array(
        __NAMESPACE__ => 'application/layout'
    ),
);