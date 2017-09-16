<?php

/*
 * Test cases for logic game
 */

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
include __DIR__.'/../src/ElectricGame.class.php';

use src\ElectricGame;

class TestElectricGame extends UnitTestCase {

  function TestIsNewGame() {
    $game = new ElectricGame([]);
    $this->assertFalse($game->isGameStart());
  }


  function TestIsFinishForEmptyGame() {
    $game = new ElectricGame([]);
    $this->assertFalse($game->isGameFinish());
  }


  function TestStartNewGame() {
    $game = new ElectricGame([]);
    $game->start();

    $matrix = $game->getMatrix();
    $expect = [
      1=>false,   2=>false,   3=>false,   4=>false,
      5=>false,   6=>false,   7=>false,   8=>false,   9=>false,
      10=>false,  11=>false,  12=>false,  13=>false,  14=>false,
      15=>false,  16=>false,  17=>false,  18=>false,  19=>false,
      20=>false,  21=>false,  22=>false,  23=>false,  24=>false, 25=>false
    ];
    $this->assertEqual($matrix, $expect);

    $this->assertTrue($game->isGameStart());
    $this->assertEqual($game->getCountMoves(), 0);
  }


  function TestMoveForEmptyGame() {
    $game = new ElectricGame([]);

    $game->doMove(1);
    $matrix = $game->getMatrix();
    $this->assertEqual($matrix, []);
  }


  function TestMoveAtCorner() {
    $game = $this->_createTestGame();

    $game->doMove(1);
    $matrix = $game->getMatrix();

    $expect = [
      1=>true,   2=>true,   3=>false,   4=>false,   5=>false,
      6=>true,   7=>true,   8=>false,   9=>false,   10=>false,
      11=>false,  12=>false,  13=>false,  14=>false, 15=>false,
      16=>false,  17=>false,  18=>false,  19=>false, 20=>false,
      21=>false,  22=>false,  23=>false,  24=>false, 25=>false
    ];
    $this->assertEqual($matrix, $expect);
    $this->assertEqual($game->getCountMoves(), 1);
  }


  function TestMoveAtAlreadyOnLamp() {
    $game = $this->_createTestGame();

    $game->doMove(1);
    $game->doMove(6);
    $matrix = $game->getMatrix();
    $expect = [
      1=>true,   2=>true,   3=>false,   4=>false,   5=>false,
      6=>true,   7=>true,   8=>false,   9=>false,   10=>false,
      11=>false,  12=>false,  13=>false,  14=>false, 15=>false,
      16=>false,  17=>false,  18=>false,  19=>false, 20=>false,
      21=>false,  22=>false,  23=>false,  24=>false, 25=>false
    ];

    $this->assertEqual($matrix, $expect);
    $this->assertEqual($game->getCountMoves(), 1);
  }

  function TestMoveWithCrossLampsArea() {
    $game = $this->_createTestGame();

    $game->doMove(7);
    $game->doMove(14);
    $matrix = $game->getMatrix();
    $expect = [
      1=>true,   2=>true,   3=>true,    4=>false,   5=>false,
      6=>true,   7=>true,   8=>false,   9=>true,    10=>true,
      11=>true,  12=>true,  13=>false,  14=>true,   15=>true,
      16=>false, 17=>false, 18=>true,   19=>true,   20=>true,
      21=>false, 22=>false, 23=>false,  24=>false,  25=>false
    ];

    $this->assertEqual($matrix, $expect);
    $this->assertEqual($game->getCountMoves(), 2);
  }


  function TestMoveWithFinishGame() {
    $game = $this->_createTestGame();

    $game->doMove(7);
    $game->doMove(22);
    $game->doMove(10);
    $game->doMove(25);

    $matrix = $game->getMatrix();
    $expect = [
      1=>true,   2=>true,   3=>true,   4=>true,    5=>true,
      6=>true,   7=>true,   8=>true,   9=>true,    10=>true,
      11=>true,  12=>true,  13=>true,  14=>true,   15=>true,
      16=>true, 17=>true,   18=>true,  19=>true,   20=>true,
      21=>true, 22=>true,   23=>true,  24=>true,   25=>true
    ];

    $this->assertEqual($matrix, $expect);
    $this->assertEqual($game->getCountMoves(), 4);
    $this->assertTrue($game->isGameFinish());
  }


  function _createTestGame($matrix = []) {
    $game = new ElectricGame($matrix);
    $game->setRandomMagic(false);
    $game->start();

    return $game;
  }

}
