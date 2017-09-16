<?php
/**
 * Main game script
 * 
 * GET Pagams:
 * action:
 *  start - start new game
*   move=N [1-25] make new move
 *  save=name - save result game 
 */


$game = new ElectricGame();
if (!isset($GET['action']) || !method_exists($game, $GET['action'])) {
  die('bag action');
}

$game->$action($_GET);

$data['count_moves'] = $game->getCountMoves();
$data['matrix'] = $game->getMatrix();
$data['status'] = $game->getStatus();
$data['time'] = $game->getTime();

json_encode($data);