<?php
/**
 * config file für unser LwcMultipleChoice Modul 
 */
namespace LwcMultipleChoice;

return array(
  'router' => array(
        'routes' => array(
            'testTest' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/test[/:id]',
                    'constraints' => array(                        
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'LwcMultipleChoice\Controller\Test',
                        'action'     => 'test',
                    ),
                ),
            ),
            'testIndex' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/test[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',                        
                    ),
                    'defaults' => array(
                        'controller' => 'LwcMultipleChoice\Controller\Test',
                        'action'     => 'index',
                    ),
                ),
            ),
            
        ),
    ),
  'controllers' => array(
    'invokables' => array(
            'LwcMultipleChoice\Controller\Test' => 'LwcMultipleChoice\Controller\TestController',
        ),
  ),
  'view_manager' => array(
     'template_path_stack' => array(
            'location' => __DIR__ . '/../view',
        ),
  ),
  'doctrine' => array(
    'driver' => array(
      __NAMESPACE__ . '_driver' => array(
        'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
        'cache' => 'array',
        'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')        
      ),
      'orm_default' => array(
        'drivers' => array(
          __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
        )
      )
    )
  )
);