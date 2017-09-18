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
include '../src/ElectricGame5x5.class.php';
include '../src/ElectricGame8x8.class.php';
use src\ElectricGame5x5;
use src\ElectricGame8x8;

if (!isset($_GET['action'])) {
  die('bag action');
}

// for PHP 7
random_int(0, 10000);

$sesion = 'electric_game';

if (isset($_SESSION[$sesion])) {
  $game = new ElectricGame8x8($_SESSION[$sesion]);
} else {
  $game = new ElectricGame8x8([]);
  $game->start(GAME_LEVEL_NORMAL);
}

// $game->setRandomMagic(false);


$action = $_GET['action'];
switch ($action) {
  case 'start':
    if (isset($_GET['value']))
      $game->start($_GET['value']);
    break;
  case 'move':
    if (isset($_GET['value'])) {
      $game->doMove($_GET['value']);
    }
    break;
  case 'freeze':
    if (isset($_GET['value'])) {
      $game->doFreeze($_GET['value']);
    }
    break;
  case 'save':
    if (isset($_GET['value'])) {
      $game->save($db, $_GET['value']);
      // TODO FIX IT save name for next win game
      //$gameData['player_name'] = $_GET['value'];
      $game->start();
    }
}

$_SESSION[$sesion] = $game->getData();

echo (json_encode($game->getData()));
