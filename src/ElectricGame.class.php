<?php
namespace src;

/**
 * Class for game logic
 *
 * @author Dan Efimov <efimov82@gmail.com>
 */
class ElectricGame {

  protected $timeStart = 0;
  protected $timeFinish = 0;
  protected $countMoves = 0;
  protected $randomMagic = true;

  protected $matrixSize = 25;
  protected $matrix = [];
  protected $gameFields = [
  1 =>	[2,6,7],
  2 =>	[	1,6,7,8,3],
  3 =>	[	2,7,8,9,4],
  4 =>	[	3,8,9,10,5],
  5 =>	[	4,9,10],
  6 =>	[	1,2,7,11,12],
  7 =>	[	1,2,3,6,8,11,12,13],
  8 =>	[	2,3,4,7,9,12,13,14],
  9 =>	[	3,4,5,8,10,13,14,15],
  10 =>	[	4,5,9,14,15],
  11 =>	[	6,7,12,16,17],
  12 =>	[	6,7,8,11,13,16,17,18],
  13 =>	[	7,8,9,12,14,17,18,19],
  14 =>	[	8,9,10,13,15,18,19,20],
  15 =>	[	9,10,14,19,20],
  16 =>	[	11,12,17,21,22],
  17 =>	[	11,12,13,16,18,21,22,23],
  18 =>	[	12,13,14,17,19,22,23,24],
  19 =>	[	13,14,15,18,20,23,24,25],
  20 =>	[	14,15,19,24,25],
  21 =>	[	16,17,22],
  22 =>	[	16,17,18,21,23],
  23 =>	[	17,18,19,22,24],
  24 =>	[	18,19,20,23,25],
  25 =>	[	19,20,24]
  ];

  function __construct($data) {
    if (isset($data['matrix']) &&
        isset($data['timeStart']) &&
        isset($data['countMoves'])) {
          $this->matrix = $data['matrix'];
          $this->timeStart = $data['timeStart'];
          $this->countMoves = $data['countMoves'];
        }
  }

  /**
   * Start new game
   *
   * @return void
   */
  public function start() {
    $this->matrix = [];
    for($i = 1; $i <= $this->matrixSize; $i++) {
      $this->matrix[$i] = false;
    }

    $this->timeStart = time();
    $this->timeFinish = 0;
    $this->countMoves = 0;
  }

  /**
   * Make new move in game
   *
   * @param [type] $params
   * @return void
   */
  public function doMove($value) {
    if (!$this->isGameStart() || $this->isGameFinish())
      return false;

    if ((int)$value > 0 && (int)$value <= $this->matrixSize)
      return $this->move((int)$value);

    return false;
  }

  public function save($params) {
    // TODO save to DB {date, name, countMoves, time}
    $time = time() - $this->timeStart;

    return true;
  }

public function getMatrix() {
  return $this->matrix;
}

public function isGameStart() {
    return $this->timeStart > 0;
  }

  public function isGameFinish() {
    if (!$this->isGameStart())
      return false;

    foreach($this->matrix as $index=>$value) {
      if (!$value)
        return false;
    }

    return true;
  }

  public function getCountMoves() {
    return $this->countMoves;
  }

public function setRandomMagic($val) {
  $this->randomMagic = (bool)$val;
}
  /**
   * Do next move in game
   *
   * @param [integer] $move
   * @return bool
   */
  protected function move($move) {
    $res = $this->applyMoveToMatrix($move);
    if ($res) {
      $this->applyMagicToMatrix();
      $this->countMoves++;
    }

    if ($this->isGameFinish())
      $this->timeFinish = time();

    return $res;
  }

/**
 * Apply only if Lamp state = OFF
 *
 * @param [type] $move
 * @return void
 */
  protected function applyMoveToMatrix($move) {
    if ($this->matrix[$move])
      return false;

    $arr = $this->gameFields[$move];
    foreach($arr as $i) {
      $this->matrix[$i] = !$this->matrix[$i];
    }
    $this->matrix[$move] = true;

    return true;
  }

  /**
   * Random lamp Off
   *
   * @return void
   */
  protected function applyMagicToMatrix() {
    if (!$this->randomMagic)
      return;

    $index = rand(0,$this->matrixSize);

    if (rand(0, 1) && $this->matrix[$index]) {
      $this->matrix[$index] = false;
    }
  }

}
