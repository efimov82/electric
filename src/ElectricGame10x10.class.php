<?php

namespace src;
use src\ElectricGame8x8;

/**
 * Class for game logic
 *
 * @author Dan Efimov <efimov82@gmail.com>
 */
class ElectricGame10x10 extends ElectricGame8x8 {

  /**
   * Size matrix game 8x8
   * @var integer
   */
  protected $gameLabel      = '10x10';
  protected $matrixSize     = 100;
  protected $gameSize       = '10x10';
  protected $matrixLen      = 10;
  protected $supportActions = ['move', 'freeze', 'start', 'save', 'vline', 'gline', 'cross', 'diagonal'];
  protected $costsMove      = ['freeze'=>3, 'vline'=>5, 'gline'=>5, 'cross'=>10, 'diagonal'=>10];


  /**
   * Random behavior depending on the difficulty level
   * level  low =     10%
   *        normal =  20%
   *        hard =    30%
   */
  protected function needApplyChange() {

    $res = rand(0, 100) < $this->difficulty * 10;
    return $res;
  }
}
