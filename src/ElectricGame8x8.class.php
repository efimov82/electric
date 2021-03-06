<?php

namespace src;
use src\AbstractGame;

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
  protected $gameLabel      = '8x8';
  protected $matrixSize     = 64;
  protected $gameSize       = '8x8';
  protected $matrixLen      = 8;
  protected $supportActions = ['move', 'freeze', 'start', 'save', 'vline', 'gline', 'cross', 'diagonal'];
  protected $costsMove      = ['freeze'=>3, 'vline'=>4, 'gline'=>4, 'cross'=>8, 'diagonal'=>8];
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

  public function glineAction($params) {
    if (!$this->isGameStart() || $this->isGameFinish())
      return false;

    $val = $this->_getIntValue($params);
    if (!$val || $this->matrix[$val] != LS_OFF)
      return false;

    $lamps = $this->_getLampsForGLine($val);
    $this->_applyReverceTransform($val, $lamps);
    $this->countMoves += $this->costsMove['vline']; // same value
    $this->afterAction($val);
  }

  public function crossAction($params) {
    if (!$this->isGameStart() || $this->isGameFinish())
      return false;

    $val = $this->_getIntValue($params);
    if (!$val || $this->matrix[$val] != LS_OFF)
      return false;

    $lamps = $this->_getLampsForGLine($val);
    $this->_applyReverceTransform($val, $lamps);

    $lamps = $this->_getLampsForVLine($val);
    $this->_applyReverceTransform($val, $lamps);

    $this->countMoves += 2 * $this->costsMove['vline']; // same value
    $this->afterAction($val);
  }

  public function diagonalAction($param) {
    // TODO
  }

  protected function _getLampsForVLine($val) {
    $res = [];
    for($i=1; $i <= $this->matrixSize; $i++) {
      if (($i % $this->matrixLen) == ($val % $this->matrixLen))
        $res[] = $i;
    }
    return $res;
  }

  protected function _getLampsForGLine($val) {
    $res = [];
    $start = floor(($val-1) / $this->matrixLen) * $this->matrixLen + 1;
    for($i = $start; $i < $start + $this->matrixLen; $i++)
      $res[] = $i;

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
    return in_array($number, [1,
                              $this->matrixLen,
                              ($this->matrixLen * ($this->matrixLen-1)) + 1,
                              $this->matrixLen * $this->matrixLen]); // 1,8,57,64
  }

  protected function isItLeftCol($number) {
    return $number % $this->matrixLen == 1;
  }

  protected function isItRightCol($number) {
    return $number % $this->matrixLen == 0;
  }

  protected function isItFirsLine($number) {
    return $number < ($this->matrixLen + 1);
  }

  protected function isItLastLine($number) {
    return $number > ($this->matrixLen * ($this->matrixLen - 1));
  }

  protected function _getLampForCorner($number) {
    if ($number == 1) {
      return [2, $this->matrixLen + 1, $this->matrixLen + 2];//[2,9,10];
    }
    if ($number == $this->matrixLen) {
      return [$this->matrixLen - 1, ($this->matrixLen * 2) - 1, $this->matrixLen * 2];
    }
    if ($number == ($this->matrixLen * ($this->matrixLen - 1) + 1) ) { // 57
      return [$this->matrixLen * ($this->matrixLen - 2) + 1,
          $this->matrixLen * ($this->matrixLen - 2) + 2,
          $this->matrixLen * ($this->matrixLen - 1) + 2]; // 49,50,58
    }
    if ($number == $this->matrixLen * $this->matrixLen) {
      return [$this->matrixLen * ($this->matrixLen-1) - 1,
              $this->matrixLen * ($this->matrixLen-1),
              $this->matrixLen * $this->matrixLen - 1]; // 55, 56, 63
    }
  }

  protected function _getLampForLeftCol($n) {
    return [$n - $this->matrixLen, $n - $this->matrixLen + 1,
        $n + 1, $n + $this->matrixLen, $n + $this->matrixLen + 1]; //[$n-8, $n-7, $n+1, $n+8, $n+9];
  }

  protected function  _getLampForRightCol($n) {
    return [$n - $this->matrixLen - 1, $n - $this->matrixLen,
        $n - 1, $n + $this->matrixLen - 1, $n + $this->matrixLen]; //[$n-9, $n-8, $n-1, $n+7, $n+8];
  }

  protected function getLampForFirstLine($n) {
    return [$n - 1, $n + 1, $n + $this->matrixLen - 1,
        $n + $this->matrixLen, $n + $this->matrixLen + 1];
  }

  protected function getLampForLastLine($n) {
    return [$n - $this->matrixLen - 1, $n - $this->matrixLen,
        $n - $this->matrixLen + 1, $n-1, $n+1]; // $n-9, $n-8, $n-7, $n-1, $n+1
  }

  protected function getLampForMiddle($n) {
    return [$n - $this->matrixLen - 1, $n - $this->matrixLen,
        $n - $this->matrixLen + 1, $n-1, $n+1,
        $n + $this->matrixLen - 1, $n + $this->matrixLen, $n + $this->matrixLen + 1]; // $n-9, $n-8, $n-7, $n-1, $n+1, $n+7, $n+8, $n+9
  }
}
