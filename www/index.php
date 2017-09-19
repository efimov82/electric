<!DOCTYPE html>
<html lang="en">
<?php
include_once '../bootstrap.php';
include '_html/header.php';
?>
<body>

  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Electric game</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/">Game</a></li>
      <li><a href="/top.php">TOP10</a></li>
      <li><a href="/rules.php">Rules</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <div  id="game" class="cell">
    <div id="gameInfo" class="gameInfo">
      Difficulty: <span id="difficultyLevel">none</span>,
      Count FREEZE: <span id="countFreeze">0</span>,
      Time: <span id="timePlay">0</span>
    </div>
    <div id="gameCells" class="col-sm-10 gameField">
      <?php include "_html/game_field{$gameSize}.html"; ?>
      <div id="flip-counter" class="flip-counter"></div>
      <button class="btn" onclick="$('#modalNew').modal('show');">New game</button>
    </div>

    <div class="col-sm-2 toolsPanel" id="tools">
      <div class="row">
        <div>TOOLS</div>
          <?php include "_html/tools{$gameSize}.html"; ?>
      </div>
    </div>

  </div>
</div>

    <!-- save game -->
    <div id="modalSave" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Victory!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <p>Congratulation! You did it! Tell your name to save in TOP10.</p>
          <input id="player_name" type="input" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveWinner()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <!-- new game -->
    <div id="modalNew" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Start new game</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <p>Choose level difficulty:
            <select id="game-difficulty">
              <option value="1">Easy</option>
              <option value="2">Normal</option>
              <option value="3">Hard</option>
            </select>
          </p>
          <p>Choose size game field:
            <select id="game-size">
              <option value="5x5">5x5</option>
              <option value="8x8">8x8</option>
              <option value="10x10">10x10</option>
            </select>
          </p>
          <div>
            <p><strong>Easy:</strong> You have 3 Freeze tool and simple gameplay.</p>
            <p><strong>Normal:</strong> You have 2 Freeze tool and medium gameplay.</p>
            <p><strong>Hard:</strong>You have 1 Freeze tool and medium gameplay.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="newGame()">START</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>