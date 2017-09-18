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
  protected $matrixSize = 64;

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
