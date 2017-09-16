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

include '../src/ElectricGame.class.php';
use src\ElectricGame;

if (!isset($_GET['action'])) {
  die('bag action');
}


$sesion = 'electric_game';
$game = new ElectricGame(isset($_SESSION[$sesion]) ? $_SESSION[$sesion] : []);

if (!isset($_SESSION[$sesion])) {
  $game->start();
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
      $game->save($_GET['value']);
      $game->start();
    }
}

$data['count_moves'] = $game->getCountMoves();
$data['matrix'] = $game->getMatrix();
$data['status'] = $game->getStatus();
$data['time_start'] = $game->getTimeStart();

$_SESSION[$sesion] = $data;

echo (json_encode($data));
