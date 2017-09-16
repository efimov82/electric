<?php
/**
 * Main game script
 *
 * GET Params:
 * action:
 *  start - start new game
 *  state - current game data
*   move [1-25] make new move
 *  save=name - save result game
 */
session_start();

include '../src/ElectricGame.class.php';
use src\ElectricGame;

if (!isset($_GET['action'])) {
  die('bag action');
}

//print_r($_SESSION);

$sesion = 'electric_game';
$game = new ElectricGame(isset($_SESSION[$sesion]) ? $_SESSION[$sesion] : []);

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
    // TODO

}

$data['count_moves'] = $game->getCountMoves();
$data['matrix'] = $game->getMatrix();
$data['status'] = $game->getStatus();
$data['time_start'] = $game->getTimeStart();

$_SESSION[$sesion] = $data;

echo (json_encode($data));
