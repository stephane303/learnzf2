<?php
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Debug\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            // Simply drop new controllers in, and you can access them
            // using the path /debug/:controller/:action
            'debug' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/debug',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Debug\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Debug\Controller\Index' => 'Debug\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
