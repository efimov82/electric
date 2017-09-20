<?php
//namespace src;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;

require_once "vendor/autoload.php";
require_once "config/database.php";

session_start();

$gameSizes = ['5x5', '8x8', '10x10'];

$session_name = 'electric_game';
if (isset($_SESSION[$session_name]['game_size']) && in_array($_SESSION[$session_name]['game_size'], $gameSizes)) {
  $gameSize = $_SESSION[$session_name]['game_size'];
} else {
  $gameSize = '5x5';
}


//$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
//$queryBuilder = $conn->createQueryBuilder();

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Entity"), $isDevMode);

// obtaining the entity manager
$entityManager = EntityManager::create($connectionParams, $config);
$db = DriverManager::getConnection($connectionParams, $config);




function AutoLoader($className)
{
  $file = str_replace('\\', DIRECTORY_SEPARATOR, $className);

  require_once __DIR__ . DIRECTORY_SEPARATOR . $file . '.class.php';
    //Make your own path, Might need to use Magics like ___DIR___
}

spl_autoload_register('AutoLoader');