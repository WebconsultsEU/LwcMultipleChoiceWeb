<?php
/**
 * config file für unser LwcMultipleChoice Modul 
 */
namespace LwcMultipleChoice;

return array(
  'router' => array(
        'routes' => array(
            'location' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/test[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
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
        'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
        'cache' => 'array',
        'paths' => array(dirname(dirname(dirname(__DIR__))) . '/db/xml')
      ),
      'orm_default' => array(
        'drivers' => array(
          __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
        )
      )
    )
  )
);