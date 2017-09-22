<?php
namespace src;

require_once "../bootstrap.php";
require __DIR__.'/../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

use src\GamesFactory;

if (!isset($_GET['action'])) {
  die('bag action');
}

$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/../config/electric-game.json');
$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://electric-game.firebaseio.com')
    ->create();
$database = $firebase->getDatabase();


if ($_GET['action'] == 'start') { //  && 
  $key = substr(sha1(rand(1,10000)), 1, 5);
  // for create new game
  $row['key'] = $key;
} elseif (isset($_GET['key'])) {
  $key = $_GET['key'];
  $row = $database->getReference("games/$key")->getValue();
  if (!$row) {
    die('game not found');
  } else {
    unset($row['matrix'][0]);
  }
  
} else {
  die ('key not set');
}

$game = GamesFactory::create($_GET, $row);

$action = $_GET['action'] .'Action';
if (method_exists($game, $action)) {
  $game->$action($_GET);
}

$database->getReference('games/'.$key)->update($game->getData());

  /*$newPost = $database
    ->getReference("games")
    ->push([
        'size' => '8x8',
        'field' => '{1:2, 3:4}',
        'time' => time()
    ]);
*/
 // echo ($newPost->getKey()); // => -KVr5eu8gcTv7_AHb-3-

echo (json_encode($game->getData()));