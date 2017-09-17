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
session_start();

require_once "../bootstrap.php";
include '../src/ElectricGame.class.php';
use src\ElectricGame;

if (!isset($_GET['action'])) {
  die('bag action');
}


$sesion = 'electric_game';
$gameData = isset($_SESSION[$sesion]) ? $_SESSION[$sesion] : [];

$game = new ElectricGame($gameData);
// $game->setRandomMagic(false);

if (!isset($_SESSION[$sesion])) {
  $game->start(GAME_LEVEL_SIMPLE);
}

$action = $_GET['action'];
switch ($action) {
  case 'start':
    $game->start();
    break;
  case 'move':
    if (isset($_GET['value'])) {
      $game->doMove($_GET['value']);
    }
    break;
  case 'save':
    if (isset($_GET['value'])) {
      $game->save($db, $_GET['value']);
      // save name for next win game
      $gameData['player_name'] = $_GET['value'];
      $game->start();
    }
}

$gameData['count_moves'] = $game->getCountMoves();
$gameData['matrix'] = $game->getMatrix();
$gameData['status'] = $game->getStatus();
$gameData['time_start'] = $game->getTimeStart();

$_SESSION[$sesion] = $gameData;

echo (json_encode($gameData));
