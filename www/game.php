<?php
/**
 * Main game script
 *
 * GET Params:
 * action:
 *  start - start new game
 *  state - current game data
*   move [1-25] take new move
 *  save - save result game
 */
namespace src;

require_once "../bootstrap.php";
use src\GamesFactory;

if (!isset($_GET['action'])) {
  die('bag action');
}


if (isset($_SESSION[$session_name])) {
  $game = GamesFactory::create($_GET, $_SESSION[$session_name]);
} else {
  $game = GamesFactory::create($_GET, []);
  // TODO refactoring later At front and remove
  $game->startAction(['value'=>GAME_LEVEL_NORMAL]);
}

$game->setDb($db);

// $game->setRandomMagic(false);

if (!isset($_GET['action']))
  die('action is require');

$action = $_GET['action'] .'Action';
if (method_exists($game, $action)) {
  $game->$action($_GET);
}

$_SESSION[$session_name] = $game->getData();

echo (json_encode($game->getData()));
