<?php

/*
 * Test cases for logic game
 */

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
include __DIR__.'/../src/ElectricGame.class.php';

use src\ElectricGame;

class TestElectricGame extends UnitTestCase {

  function TestIsNewGame() {

    //echo("\n on+freez=".(LS_ON + LS_FREEZED));
    //echo("\n off+freez=".(LS_OFF + LS_FREEZED));

    $game = new ElectricGame([]);
    $this->assertFalse($game->isGameStart());
  }


  function TestIsFinishForEmptyGame() {
    $game = new ElectricGame([]);
    $this->assertFalse($game->isGameFinish());
  }



  function TestStartNewGame() {
    $game = new ElectricGame([]);
    $game->setRandomMagic(false);
    $game->start();

    $matrix = $game->getMatrix();
    $expect = [
      1=>LS_OFF,   2=>LS_OFF,   3=>LS_OFF,   4=>LS_OFF,
      5=>LS_OFF,   6=>LS_OFF,   7=>LS_OFF,   8=>LS_OFF,   9=>LS_OFF,
      10=>LS_OFF,  11=>LS_OFF,  12=>LS_OFF,  13=>LS_OFF,  14=>LS_OFF,
      15=>LS_OFF,  16=>LS_OFF,  17=>LS_OFF,  18=>LS_OFF,  19=>LS_OFF,
      20=>LS_OFF,  21=>LS_OFF,  22=>LS_OFF,  23=>LS_OFF,  24=>LS_OFF, 25=>LS_OFF
    ];
    $this->assertEqual($matrix, $expect);

    $this->assertTrue($game->isGameStart());
    $this->assertEqual($game->getCountMoves(), 0);
  }

  function TestIsFinishForOpenGame() {
    $game = $this->_createTestGame();
    $game->doMove(2);

    $this->assertFalse($game->isGameFinish());
  }

  function TestIsFinishGame() {
    $game = $this->_createTestGame();
    $game->doMove(7);
    $game->doMove(22);
    $game->doMove(10);
    $game->doMove(25);

    $this->assertTrue($game->isGameFinish());
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
      1=>LS_ON,    2=>LS_ON,    3=>LS_OFF,   4=>LS_OFF,   5=>LS_OFF,
      6=>LS_ON,    7=>LS_ON,    8=>LS_OFF,   9=>LS_OFF,   10=>LS_OFF,
      11=>LS_OFF,  12=>LS_OFF,  13=>LS_OFF,  14=>LS_OFF, 15=>LS_OFF,
      16=>LS_OFF,  17=>LS_OFF,  18=>LS_OFF,  19=>LS_OFF, 20=>LS_OFF,
      21=>LS_OFF,  22=>LS_OFF,  23=>LS_OFF,  24=>LS_OFF, 25=>LS_OFF
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
      1=>LS_ON,   2=>LS_ON,   3=>LS_OFF,   4=>LS_OFF,   5=>LS_OFF,
      6=>LS_ON,   7=>LS_ON,   8=>LS_OFF,   9=>LS_OFF,   10=>LS_OFF,
      11=>LS_OFF,  12=>LS_OFF,  13=>LS_OFF,  14=>LS_OFF, 15=>LS_OFF,
      16=>LS_OFF,  17=>LS_OFF,  18=>LS_OFF,  19=>LS_OFF, 20=>LS_OFF,
      21=>LS_OFF,  22=>LS_OFF,  23=>LS_OFF,  24=>LS_OFF, 25=>LS_OFF
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
      1=>LS_ON,   2=>LS_ON,   3=>LS_ON,    4=>LS_OFF,   5=>LS_OFF,
      6=>LS_ON,   7=>LS_ON,   8=>LS_OFF,   9=>LS_ON,    10=>LS_ON,
      11=>LS_ON,  12=>LS_ON,  13=>LS_OFF,  14=>LS_ON,   15=>LS_ON,
      16=>LS_OFF, 17=>LS_OFF, 18=>LS_ON,   19=>LS_ON,   20=>LS_ON,
      21=>LS_OFF, 22=>LS_OFF, 23=>LS_OFF,  24=>LS_OFF,  25=>LS_OFF
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
      1=>LS_ON,   2=>LS_ON,   3=>LS_ON,   4=>LS_ON,    5=>LS_ON,
      6=>LS_ON,   7=>LS_ON,   8=>LS_ON,   9=>LS_ON,    10=>LS_ON,
      11=>LS_ON,  12=>LS_ON,  13=>LS_ON,  14=>LS_ON,   15=>LS_ON,
      16=>LS_ON, 17=>LS_ON,   18=>LS_ON,  19=>LS_ON,   20=>LS_ON,
      21=>LS_ON, 22=>LS_ON,   23=>LS_ON,  24=>LS_ON,   25=>LS_ON
    ];

    $this->assertEqual($matrix, $expect);
    $this->assertEqual($game->getCountMoves(), 4);
    $this->assertTrue($game->isGameFinish());
  }

  /*
   * Freez
   */
  function TestFreezeSateOnLamp() {
    $game = $this->_createTestGame();

    $game->doMove(2);
    $game->doFreeze(7);

    $matrix = $game->getMatrix();
    $expect = [
      1=>LS_ON,   2=>LS_ON,             3=>LS_ON,     4=>LS_OFF,    5=>LS_OFF,
      6=>LS_ON,   7=>LS_ON + LS_FREEZED,8=>LS_ON,     9=>LS_OFF,    10=>LS_OFF,
      11=>LS_OFF, 12=>LS_OFF,           13=>LS_OFF,   14=>LS_OFF,   15=>LS_OFF,
      16=>LS_OFF, 17=>LS_OFF,           18=>LS_OFF,   19=>LS_OFF,   20=>LS_OFF,
      21=>LS_OFF, 22=>LS_OFF,           23=>LS_OFF,   24=>LS_OFF,   25=>LS_OFF
    ];

    $this->assertEqual($matrix, $expect);
    $this->assertEqual($game->getCountMoves(), 1 + $game->getCostsMove()['freeze']);
  }

  function TestFreezeOnFreezedLamp() {
    $game = $this->_createTestGame();

    $game->doMove(2);
    $game->doFreeze(7);
    $game->doFreeze(7);

    $matrix = $game->getMatrix();
    $expect = [
      1=>LS_ON,   2=>LS_ON,             3=>LS_ON,     4=>LS_OFF,    5=>LS_OFF,
      6=>LS_ON,   7=>LS_ON + LS_FREEZED,8=>LS_ON,     9=>LS_OFF,    10=>LS_OFF,
      11=>LS_OFF, 12=>LS_OFF,           13=>LS_OFF,   14=>LS_OFF,   15=>LS_OFF,
      16=>LS_OFF, 17=>LS_OFF,           18=>LS_OFF,   19=>LS_OFF,   20=>LS_OFF,
      21=>LS_OFF, 22=>LS_OFF,           23=>LS_OFF,   24=>LS_OFF,   25=>LS_OFF
    ];

    $this->assertEqual($matrix, $expect);
    $this->assertEqual($game->getCountMoves(), 1 + $game->getCostsMove()['freeze']);
  }

  function TestFreezedLampOnNextMove() {
    $game = $this->_createTestGame();

    $game->doMove(2);
    $game->doFreeze(7);
    $game->doMove(12);

    $matrix = $game->getMatrix();
    $expect = [
      1=>LS_ON,   2=>LS_ON,   3=>LS_ON,   4=>LS_OFF,    5=>LS_OFF,
      6=>LS_OFF,  7=>LS_ON,   8=>LS_OFF,  9=>LS_OFF,    10=>LS_OFF,
      11=>LS_ON,  12=>LS_ON,  13=>LS_ON,  14=>LS_OFF,   15=>LS_OFF,
      16=>LS_ON,  17=>LS_ON,  18=>LS_ON,  19=>LS_OFF,   20=>LS_OFF,
      21=>LS_OFF, 22=>LS_OFF, 23=>LS_OFF, 24=>LS_OFF,   25=>LS_OFF
    ];

    $this->assertEqual($matrix, $expect);
  }

  function TestApplyFreezeOverLimit() {

  }


  /**
   *
   * @param type $matrix
   * @return ElectricGame
   */
  function _createTestGame($matrix = []) {
    $game = new ElectricGame($matrix);
    $game->setRandomMagic(false);
    $game->start();

    return $game;
  }

}
