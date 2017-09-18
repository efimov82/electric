<?php

namespace src;
require_once __DIR__.'/AbstractGame.class.php';
use AbstractGame;

/**
 * Class for game logic
 *
 * @author Dan Efimov <efimov82@gmail.com>
 */
class ElectricGame8x8 extends AbstractGame {

  /**
   * Size matrix game 8x8
   * @var integer
   */
  protected $gameLabel = '8x8';
  protected $matrixSize = 64;
  protected $supportActions = ['move', 'freeze', 'start', 'save', 'vline', 'gline', 'cross', 'diagonal'];
  protected $costsMove = ['freeze'=>3, 'vline'=>4, 'gline'=>4, 'cross'=>8, 'diagonal'=>8];
  /**
   * Apply transform for vertical matrix line
   *
   * @param type $param
   */
  public function vlineAction($params) {
    if (!$this->isGameStart() || $this->isGameFinish())
      return false;

    $val = $this->_getIntValue($params);
    if (!$val || $this->matrix[$val] != LS_OFF)
      return false;

    $lamps = $this->_getLampsForVLine($val);
    $this->_applyReverceTransform($val, $lamps);
    $this->countMoves += $this->costsMove['vline'];
    $this->afterAction($val);

    return true;
  }

  public function glineAction($param) {

  }

  public function crossAction($param) {

  }

  public function diagonalAction($param) {

  }

  protected function _getLampsForVLine($val) {
    $res = [];
    for($i=1; $i <= $this->matrixSize; $i++) {
      if (($i % 8) == ($val % 8))
        $res[] = $i;
    }
    return $res;
  }

  public function getLampAround($number) {
    if ($this->isItCorner($number)) {
      $res = $this->_getLampForCorner($number);
    }
    elseif ($this->isItLeftCol($number)) {
      $res = $this->_getLampForLeftCol($number);
    }
    elseif ($this->isItRightCol($number)) {
      $res = $this->_getLampForRightCol($number);
    }
    elseif ($this->isItFirsLine($number)) {
      $res = $this->getLampForFirstLine($number);
    }
    elseif ($this->isItLastLine($number)) {
      $res = $this->getLampForLastLine($number);
    }
    else {
      $res = $this->getLampForMiddle($number);
    }

    $res = array_values($res);
    sort($res);
    return $res;
  }

  protected function isItCorner($number) {
    return in_array($number, [1, 8, 57, 64]);
  }

  protected function isItLeftCol($number) {
    return $number % 8 == 1;
  }

  protected function isItRightCol($number) {
    return $number % 8 == 0;
  }

  protected function isItFirsLine($number) {
    return $number < 9;
  }

  protected function isItLastLine($number) {
    return $number > 56;
  }

  protected function _getLampForCorner($number) {
    if ($number == 1) {
      return [2,9,10];
    }
    if ($number == 8) {
      return [7,15,16];
    }
    if ($number == 57) {
      return [49,50,58];
    }
    if ($number == 64) {
      return [55,56,63];
    }
  }

  protected function _getLampForLeftCol($n) {
    return [$n-8, $n-7, $n+1, $n+8, $n+9];
  }

  protected function  _getLampForRightCol($n) {
    return [$n-9, $n-8, $n-1, $n+7, $n+8];
  }

  protected function getLampForFirstLine($n) {
    return [$n-1, $n+1, $n+7, $n+8, $n+9];
  }

  protected function getLampForLastLine($n) {
    return [$n-9, $n-8, $n-7, $n-1, $n+1];
  }

  protected function getLampForMiddle($n) {
    return [$n-9, $n-8, $n-7, $n-1, $n+1, $n+7, $n+8, $n+9];
  }
}
