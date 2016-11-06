<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';
// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$isSimpleMode = FALSE;
$proxyDir = null;
$cache = null;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/Application/src/Application/Entity"), $isDevMode,$proxyDir, $cache, $isSimpleMode);



$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'tc',
);

// obtaining the entity manager
$entityManager = EntityManager::create($dbParams, $config);
