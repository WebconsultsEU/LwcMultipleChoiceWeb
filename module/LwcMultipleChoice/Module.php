<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace LwcMultipleChoice;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH, array($this, 'mvcPreDispatch'), 2);
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        
        
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array('factories' => array(
            //aliasing the zfcuser_auth_service
               'auth_service' => function ($sm) {                    
                        return $sm->get('zfcuser_auth_service');
                },
                ));
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Implementation to check the Admin rights for this event
     * This is not complete yet
     * @throws \Exception 
     * 
     *
     */
    public function checkRights(MvcEvent $event) 
    {   
        

        $routeMatch = $event->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        $action     = $routeMatch->getParam('action');
        /*if (!$acl->hasResource($controller)) {
            throw new \Exception('Resource ' . $controller . ' not defined');

        }*/
        $authService = $event->getApplication()->getServiceManager()->get('auth_service');
        $identity = $authService->getIdentity();
        
        if ($controller == 'LwcMultipleChoice\Controller\Admin' && $identity == NULL) {
            //@todo replace with pre defined login url
            $config = $this->getConfig();
            $url = $config['auth_login_url'];
            $response = $event->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            exit;

        }
    }
    
    public function mvcPreDispatch($event) {
        return $this->checkRights($event);

    }

    
    
}

