<?php

/*
 * Test cases for logic game 5x5
 */

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once __DIR__.'/../bootstrap.php';;

use src\ElectricGame5x5;

class TestElectricGame extends UnitTestCase {

  function TestIsNewGame() {
    $game = new ElectricGame5x5([]);
    $this->assertFalse($game->isGameStart());
  }


  function TestIsFinishForEmptyGame() {
    $game = new ElectricGame5x5([]);
    $this->assertFalse($game->isGameFinish());
  }



  function TestStartNewGame() {
    $game = new ElectricGame5x5([]);
    $game->setRandomMagic(false);
    $game->startAction();

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
    $game->moveAction(['value'=>2]);

    $this->assertFalse($game->isGameFinish());
  }

  function TestIsFinishGame() {
    $game = $this->_createTestGame();
    $game->moveAction(['value'=>7]);
    $game->moveAction(['value'=>22]);
    $game->moveAction(['value'=>10]);
    $game->moveAction(['value'=>25]);

    $this->assertTrue($game->isGameFinish());
  }

  function TestMoveForEmptyGame() {
    $game = new ElectricGame5x5([]);

    $game->moveAction(1);
    $matrix = $game->getMatrix();
    $this->assertEqual($matrix, []);
  }


  function TestMoveAtCorner() {
    $game = $this->_createTestGame();

    $game->moveAction(['value'=>1]);
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

    $game->moveAction(['value'=>1]);
    $game->moveAction(['value'=>6]);
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

    $game->moveAction(['value'=>7]);
    $game->moveAction(['value'=>14]);
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

    $game->moveAction(['value'=>7]);
    $game->moveAction(['value'=>22]);
    $game->moveAction(['value'=>10]);
    $game->moveAction(['value'=>25]);

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

    $game->moveAction(['value'=>2]);
    $game->freezeAction(['value'=>7]);

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

    $game->moveAction(['value'=>2]);
    $game->freezeAction(['value'=>7]);
    $game->freezeAction(['value'=>7]);


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

    $game->moveAction(['value'=>2]);
    $game->freezeAction(['value'=>7]);
    $game->moveAction(['value'=>12]);

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
    $game = new ElectricGame5x5($matrix);
    $game->setRandomMagic(false);
    $game->startAction();

    return $game;
  }

}
