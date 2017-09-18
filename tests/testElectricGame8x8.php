<?php

/*
 * Tests 8x8 game
 */

require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
include __DIR__.'/../src/ElectricGame8x8.class.php';

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

  // service fnc
  function _getLampAround($number, $expect, $print=false) {
    $game = new ElectricGame8x8();

    $arr = $game->getLampAround($number);
    if ($print)
      print_r($arr);

    //print_r($expect);
    $this->assertEqual($arr, $expect);
  }
}

