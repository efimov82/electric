<?php

define('GAME_LEVEL_EASY',     1); // 3 freez
define('GAME_LEVEL_NORMAL',   2); // 2 freez
define('GAME_LEVEL_HARD',     3); // 1 freez

// Lamp states
define('LS_OFF',      1);
define('LS_ON',       2);
define('LS_FREEZED',  4);

/*
 * Game class
 */

class AbstractGame {
  protected $timeStart  = 0;
  protected $timeFinish = 0;
  protected $countMoves = 0;
  protected $difficulty = 1;
  protected $costsMove = ['freeze'=>3];
  protected $arrFreezed = [];


  /**
   * Flag for add random change Lamp in game
   *
   * @var bool
   */
  protected $randomMagic = true;

  /**
   * Size matrix game 5x5
   * @var integer
   */
  protected $matrixSize = 25;
  protected $matrix     = [];
  protected $gameFields = [];

  protected $_importFields = ['matrix', 'countMoves', 'arrFreezed', 'timeStart', 'difficulty'];
  protected $_isInit = false;

  function __construct($data) {

    foreach ($this->_importFields as $key) {
      if (!isset($data[$key]))
        return;

      $this->$key = $data[$key];
    }

    $this->_isInit = true;
  }

  public function getData() {
    $data = [];

    foreach ($this->_importFields as $key) {
      $data[$key] = $this->$key;
    }
    // TODO rewrite after
    $data['status'] = $this->getStatus();
    $data['countFreezes'] = $this->getCountFreezeMove();
    $data['timePlay'] = $this->getTime();
    return $data;
  }
  /**
   * Start new game
   *
   * @return void
   */
  public function start($difficulty = GAME_LEVEL_NORMAL) {
    $this->matrix = [];
    for ($i = 1; $i <= $this->matrixSize; $i++) {
      $this->matrix[$i] = LS_OFF;
    }

    $this->difficulty = $difficulty;
    $this->timeStart  = time();
    $this->timeFinish = 0;
    $this->countMoves = 0;

    // add random for start game
    if ($this->randomMagic)
      $this->matrix[rand(1,25)] = LS_ON;
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

    if ((int) $value > 0 && (int) $value <= $this->matrixSize)
      return $this->move((int) $value);

    return false;
  }

  /**
   * Freeze 1 lamp to 1 move
   *
   * @param integer $value
   */
  public function doFreeze($value) {
    if (!$this->isGameStart() || $this->isGameFinish() || ($this->getCountFreezeMove() <= 0))
      return false;

    if (!isset($this->arrFreezed[$value])) {
      $this->arrFreezed[$value] = $this->matrix[$value];
      $this->matrix[$value] += LS_FREEZED;
      $this->countMoves += $this->costsMove['freeze'];
    }
  }

  public function save($db, $name) {
    if (!$this->isGameFinish())
      return false;

    $data['time']        = $this->getTime();
    $data['name']        = htmlspecialchars($name);
    $data['date_create'] = date('Y-m-d H:i:s', time());
    $data['scores']      = $this->getCountMoves();
    $data['level']       = $this->difficulty;
    $db->insert(TBL_USERS_RESULTS, $data);
    return true;
  }

  public function getMatrix() {
    return $this->matrix;
  }

  public function getFreezed() {
    return$this->arrFreezed;
  }

  public function isGameStart() {
    return $this->timeStart > 0;
  }

  public function isGameFinish() {
    if (!$this->isGameStart())
      return false;

    foreach ($this->matrix as $index => $value) {
      if ($value !== LS_ON)
        return false;
    }

    return true;
  }

  public function getTimeStart() {
    return $this->timeStart;
  }

  /**
   * Get time game from start for open game or time play for finished game
   *
   * @return int
   */
  public function getTime() {
    if ($this->isGameStart()) {
      return time() - $this->timeStart;
    } elseif ($this->isGameFinish()) {
      return $this->timeFinish - $this->timeStart;
    } else {
      return 0;
    }
  }

  public function getStatus() {
    if ($this->isGameFinish())
      return 'finished';
    if ($this->isGameStart())
      return 'proccess';

    return 'empty';
  }

  public function getCountMoves() {
    return $this->countMoves;
  }

  public function setRandomMagic($val) {
    $this->randomMagic = (bool) $val;
  }

  public function getCostsMove() {
    return $this->costsMove;
  }

  public function getCountFreezeMove() {
    return $this->getLimitFreeze() - count($this->arrFreezed);
  }

  /**
     GAME_LEVEL_SIMPLE = 3 frrez
     GAME_LEVEL_NORMAL =  2 freez
     GAME_LEVEL_HARD =  1 freez
   *
   * @return int
   */
  public function getLimitFreeze() {
    return (4 - $this->difficulty);
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
      $this->unFreezeLamps();
      $this->countMoves++;

      if ($this->isGameFinish()) {
        $this->timeFinish = time();
      } else {
        $this->applyMagicToMatrix($move);
      }
    }

    return $res;
  }

  /**
   * Apply only if Lamp state = OFF
   *
   * @param [type] $move
   * @return void
   */
  protected function applyMoveToMatrix($move) {

    if ($this->matrix[$move] != LS_OFF)
      return false;

    $arr = $this->gameFields[$move];

    foreach ($arr as $i) {

      if ($this->matrix[$i] == LS_ON) {
        $this->matrix[$i] = LS_OFF;
      } elseif ($this->matrix[$i] == LS_OFF) {
        $this->matrix[$i] = LS_ON;
      }
    }
    $this->matrix[$move] = LS_ON;

    return true;
  }

  /**
   * Unfreez all lamps
   */
  protected function unFreezeLamps() {
    foreach ($this->arrFreezed as $num=>$val) {
      $this->matrix[$num] = $val;
    }

    $this->arrFreezed = [];
  }

  /**
   * Random lamp Off
   *
   * @return void
   */
  protected function applyMagicToMatrix($move) {
    if (!$this->randomMagic)
      return;

    $index = rand(1, $this->matrixSize);
    // not apply for current move
    if ($index == $move)
      return;
    // addition logic: not apply for corners and to area aroud move
    // corners in_array($index, [1, 5, 21, 25]) || - to easy
    if (in_array($index, $this->gameFields[$move]))
      return;

    if ($this->needApplyChange() && $this->matrix[$index] == LS_ON ) {
      $this->matrix[$index] = LS_OFF;
    }
  }

  /**
   * Random behavior depending on the difficulty level
   * level  low =     25%
   *        normal =  50%
   *        hard =    75%
   */
  protected function needApplyChange() {

    $res = rand(0, 100) < $this->difficulty * 25;
    return $res;
  }
}

