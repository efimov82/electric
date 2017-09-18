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

  protected $supportActions = ['move', 'freeze', 'start', 'save'];
  /**
   * Flag for add random change Lamp in game
   *
   * @var bool
   */
  protected $randomMagic = true;

  /**
   * Size matrix game
   * @var integer
   */
  protected $matrixSize = 0;
  protected $matrix     = [];
  protected $gameFields = [];

  protected $_importFields = ['matrix', 'countMoves', 'arrFreezed', 'timeStart', 'difficulty'];
  protected $_isInit = false;

  function __construct($data = []) {

    foreach ($this->_importFields as $key) {
      if (!isset($data[$key]))
        return;

      $this->$key = $data[$key];
    }

    $this->_isInit = true;
  }

  /*public function isActionSupport($action) {
    return in_array($action, $this->supportActions);
  }

  public function doAction($action, $params) {
    if (!$this->isActionSupport($action))
      return;

    $this->$action($params);
  }*/

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
   * $param array $params [$difficulty = GAME_LEVEL_NORMAL]
   * @return void
   */
  public function startAction($params = []) {

    $this->matrix = [];
    for ($i = 1; $i <= $this->matrixSize; $i++) {
      $this->matrix[$i] = LS_OFF;
    }

    // TODO chech const value
    if (isset($params['value']) && (int)$params['value'])
      $this->difficulty = (int)$params['value'];

    $this->timeStart  = time();
    $this->timeFinish = 0;
    $this->countMoves = 0;

    // add random for start game
    if ($this->randomMagic)
      $this->matrix[rand(1,$this->matrixSize)] = LS_ON;
  }

  /**
   * Make new move in game
   *
   * @param [type] $params
   * @return void
   */
  public function moveAction($params) {
    if (!$this->isGameStart() || $this->isGameFinish())
      return false;

    if (!isset($params['value']) || !(int)$params['value'])
      return false;

    $val = (int) $params['value'];
    if (($val > 0) && ($val <= $this->matrixSize))
      return $this->_move($val);

    return false;
  }

  /**
   * Freeze 1 lamp to 1 move
   *
   * @param integer $value
   */
  public function freezeAction($params) {
    if (!$this->isGameStart() || $this->isGameFinish() || ($this->getCountFreezeMove() <= 0))
      return false;

    $val = (int) $params['value'];
    if (($val > 0) && ($val <= $this->matrixSize)) {
      if (!isset($this->arrFreezed[$val])) {
        $this->arrFreezed[$val] = $this->matrix[$val];
        $this->matrix[$val] += LS_FREEZED;
        $this->countMoves += $this->costsMove['freeze'];
      }
    }
  }

  public function saveAction($params) {
    if (!$this->isGameFinish())
      return false;

    $data['time']        = $this->getTime();
    $data['name']        = htmlspecialchars(isset($params['value']) ? $params['value'] : 'noname');
    $data['date_create'] = date('Y-m-d H:i:s', time()-$data['time']);
    $data['scores']      = $this->getCountMoves();
    $data['level']       = $this->difficulty;
    $this->db->insert(TBL_USERS_RESULTS, $data);
    return true;
  }

  public function setDb($db) {
    $this->db = $db;
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
  protected function _move($move) {
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

    $arr = $this->getLampAround($move);

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
   * Get neable lamps
   *
   * @param type $number
   */
  protected function getLampAround($number) {
    return $this->gameFields[$number];
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
    if (in_array($index, $this->getLampAround($move)))
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

