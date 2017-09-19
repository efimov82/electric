<?php

/*
 * Tests 8x8 game
 */

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once __DIR__.'/../bootstrap.php';

use src\ElectricGame8x8;


class TestElectricGame8x8 extends UnitTestCase {

  // left col
  function TestGetLampAround1() {
    $expect = [2,9,10];
    $this->_getLampAround(1, $expect);
  }

  function TestGetLampAround33() {
    $expect = [25,26,34,41,42];
    $this->_getLampAround(33, $expect);
  }

  function TestGetLampAround57() {
    $expect = [49,50,58];
    $this->_getLampAround(57, $expect);
  }

  // right col
  function TestGetLampAround8() {
    $expect = [7,15,16];
    $this->_getLampAround(8, $expect);
  }

  function TestGetLampAround48() {
    $expect = [39,40,47, 55, 56];
    $this->_getLampAround(48, $expect);
  }

  function TestGetLampAround64() {
    $expect = [55,56,63];
    $this->_getLampAround(64, $expect);
  }

  // first line
  function TestGetLampAround4() {
    $expect = [3,5,11,12,13];
    $this->_getLampAround(4, $expect);
  }

  //middle
  function TestGetLampAround30() {
    $expect = [21,22,23,29,31,37,38,39];
    $this->_getLampAround(30, $expect);
  }

  //last line
  function TestGetLampAround60() {
    $expect = [51,52,53,59,61];
    $this->_getLampAround(60, $expect);
  }

  function TestFreezedLamp() {
    $game = $this->_createTestGame();
    $game->freezeAction(['value'=>63]);

    $matrix = $game->getMatrix();

    $this->assertEqual($matrix[63], LS_OFF + LS_FREEZED);
    $this->assertEqual($game->getCountMoves(), $game->getCostsMove()['freeze']);
  }

  //********** Vline Action  ***************************
  function TestVLineAction1() {
    $game = $this->_createTestGame();
    $game->vlineAction(['value'=>1]);

    $matrix = $game->getMatrix();

    $this->assertEqual($matrix[1], LS_ON);
    $this->assertEqual($matrix[9], LS_ON);
    $this->assertEqual($matrix[17], LS_ON);
    $this->assertEqual($matrix[25], LS_ON);
    $this->assertEqual($matrix[33], LS_ON);
    $this->assertEqual($matrix[41], LS_ON);
    $this->assertEqual($matrix[49], LS_ON);
    $this->assertEqual($matrix[57], LS_ON);

    $this->assertEqual($game->getCountMoves(), $game->getCostsMove()['vline']);
  }

  function TestVLineActionMiddle() {
    $game = $this->_createTestGame();
    $game->vlineAction(['value'=>10]);

    $matrix = $game->getMatrix();

    $this->assertEqual($matrix[2], LS_ON);
    $this->assertEqual($matrix[10], LS_ON);
    $this->assertEqual($matrix[18], LS_ON);
    $this->assertEqual($matrix[26], LS_ON);
    $this->assertEqual($matrix[34], LS_ON);
    $this->assertEqual($matrix[42], LS_ON);
    $this->assertEqual($matrix[50], LS_ON);
    $this->assertEqual($matrix[58], LS_ON);

    $this->assertEqual($game->getCountMoves(), $game->getCostsMove()['vline']);
  }

  function TestVLineActionEnd() {
    $game = $this->_createTestGame();
    $game->vlineAction(['value'=>64]);

    $matrix = $game->getMatrix();

    $this->assertEqual($matrix[8], LS_ON);
    $this->assertEqual($matrix[16], LS_ON);
    $this->assertEqual($matrix[24], LS_ON);
    $this->assertEqual($matrix[32], LS_ON);
    $this->assertEqual($matrix[40], LS_ON);
    $this->assertEqual($matrix[48], LS_ON);
    $this->assertEqual($matrix[56], LS_ON);
    $this->assertEqual($matrix[64], LS_ON);

    $this->assertEqual($game->getCountMoves(), $game->getCostsMove()['vline']);
  }

  // service fnc
  function _getLampAround($number, $expect, $print=false) {
    $game = new ElectricGame8x8();

    $arr = $game->getLampAround($number);
    if ($print)
      print_r($arr);

    //print_r($expect);
    $this->assertEqual($arr, $expect);
  }

  function _createTestGame($matrix = []) {
    $game = new ElectricGame8x8($matrix);
    $game->setRandomMagic(false);
    $game->startAction();

    return $game;
  }
}

