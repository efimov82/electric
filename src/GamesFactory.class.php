<?php

namespace src;
/*
 * Games factory
 */

class GamesFactory {

  static function create($GET, $sessionData) {
    $size = isset($sessionData['game_size']) ? $sessionData['game_size'] : '';
    if (isset($GET['game_size'])) {
      $size =  $GET['game_size'];
    }

    //print_r($data);
    switch ($size) {
      case '8x8':
        $game = new \src\ElectricGame8x8($sessionData);
        break;
      case '10x10':
        $game = new \src\ElectricGame10x10($sessionData);
        break;
      case '5x5':
      default :
        $game = new \src\ElectricGame5x5($sessionData);
    }
    return $game;
  }

}

