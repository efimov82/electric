<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";
require_once "config/database.php";

//$config = new \Doctrine\DBAL\Configuration();

//$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
//$queryBuilder = $conn->createQueryBuilder();

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Entity"), $isDevMode);

// obtaining the entity manager
$entityManager = EntityManager::create($connectionParams, $config);


use Doctrine\DBAL\DriverManager;

$db = DriverManager::getConnection($connectionParams, $config);
