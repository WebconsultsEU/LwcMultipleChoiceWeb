<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';
 
error_reporting(E_ALL);
ini_set("display_errors", 1);



// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
