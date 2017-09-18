<?php

namespace src;
require __DIR__.'/AbstractGame.class.php';
use AbstractGame;


/**
 * Class for game logic
 *
 * @author Dan Efimov <efimov82@gmail.com>
 */
class ElectricGame8x8 extends AbstractGame {

  /*protected $gameFields = [
      1  => [2, 6, 7],
      2  => [1, 6, 7, 8, 3],
      3  => [2, 7, 8, 9, 4],
      4  => [3, 8, 9, 10, 5],
      5  => [4, 9, 10],
      6  => [1, 2, 7, 11, 12],
      7  => [1, 2, 3, 6, 8, 11, 12, 13],
      8  => [2, 3, 4, 7, 9, 12, 13, 14],
      9  => [3, 4, 5, 8, 10, 13, 14, 15],
      10 => [4, 5, 9, 14, 15],
      11 => [6, 7, 12, 16, 17],
      12 => [6, 7, 8, 11, 13, 16, 17, 18],
      13 => [7, 8, 9, 12, 14, 17, 18, 19],
      14 => [8, 9, 10, 13, 15, 18, 19, 20],
      15 => [9, 10, 14, 19, 20],
      16 => [11, 12, 17, 21, 22],
      17 => [11, 12, 13, 16, 18, 21, 22, 23],
      18 => [12, 13, 14, 17, 19, 22, 23, 24],
      19 => [13, 14, 15, 18, 20, 23, 24, 25],
      20 => [14, 15, 19, 24, 25],
      21 => [16, 17, 22],
      22 => [16, 17, 18, 21, 23],
      23 => [17, 18, 19, 22, 24],
      24 => [18, 19, 20, 23, 25],
      25 => [19, 20, 24]
  ];*/

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
    //print_r($res);

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
