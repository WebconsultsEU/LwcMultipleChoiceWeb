<?php

 
use Zend\Loader\AutoloaderFactory,
    Zend\Mvc\Service\ServiceManagerConfig,
    Zend\ServiceManager\ServiceManager;
 
ini_set('display_errors', true);
//chdir(__DIR__);
 
$previousDir = '.';
 
while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());
 
    if ($previousDir === $dir) {
        throw new RuntimeException(
            'Unable to locate "config/application.config.php":'
                . ' is doctrine.php in a subdir of your application skeleton?'
        );
    }
 
    $previousDir = $dir;
    chdir($dir);
}
require_once 'init_autoloader.php'; 
//require_once (getenv('ZF2_PATH') ?: 'vendor/zendframework/library') . '/Zend/Loader/AutoloaderFactory.php';
 
// Setup autoloader
AutoloaderFactory::factory();
 
// get application stack configuration
$config = include 'config/application.config.php';

// setup service manager
$serviceManager = new ServiceManager(new ServiceManagerConfig());
$serviceManager->setService('ApplicationConfig', $config);
$serviceManager->get('ModuleManager')->loadModules();



$application = $serviceManager->get('Application');
$appConfig = $application->getConfig();
$doctrineConfig = $appConfig['doctrine']['connection']['orm_default'];

//creating doctrine configurateion instance
$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$driverImpl = new Doctrine\ORM\Mapping\Driver\XmlDriver(__DIR__ . '/db/xml');

$config->setMetadataDriverImpl($driverImpl);



$config->setProxyDir(__DIR__ . '/db/proxies');
$config->setProxyNamespace('Proxies');
$config->setEntityNamespaces(array('LwcMultipleChoice\Entity'));

//generate EntityManagerInstance
//For some reason this is needed to generate PHP Classes fom the XML Mappings
//$em = \Doctrine\ORM\EntityManager::create($doctrineConfig, $config);

//For some reason this is needed to generate XML Entities from the database
$locator = $application->getServiceManager();
$em = $locator->get('doctrine.entitymanager.orm_default');

 
$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);
 
 