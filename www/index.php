<!DOCTYPE html>
<html lang="en">

  <?php include '_html/header.html'; ?>
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
  <div id="game">
    <div id="gameCells" class="container gameField">
      <div class="row">
        <div id="cell-1" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 1)"></div>
        <div id="cell-2" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 2)"></div>
        <div id="cell-3" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 3)"></div>
        <div id="cell-4" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 4)"></div>
        <div id="cell-5" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 5)"></div>
      </div>

      <div class="row">
        <div id="cell-6" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 6)"></div>
        <div id="cell-7" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 7)"></div>
        <div id="cell-8" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 8)"></div>
        <div id="cell-9" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 9)"></div>
        <div id="cell-10" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 10)"></div>
      </div>

      <div class="row">
        <div id="cell-11" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 11)"></div>
        <div id="cell-12" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 12)"></div>
        <div id="cell-13" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 13)"></div>
        <div id="cell-14" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 14)"></div>
        <div id="cell-15" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 15)"></div>
      </div>

      <div class="row">
        <div id="cell-16" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 16)"></div>
        <div id="cell-17" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 17)"></div>
        <div id="cell-18" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 18)"></div>
        <div id="cell-19" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 19)"></div>
        <div id="cell-20" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 20)"></div>
      </div>

      <div class="row">
        <div id="cell-21" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 21)"></div>
        <div id="cell-22" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 22)"></div>
        <div id="cell-23" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 23)"></div>
        <div id="cell-24" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 24)"></div>
        <div id="cell-25" class="col-xs-1 gameCell" onclick="doMove(gameCounter, 25)"></div>
      </div>

      <div>
      <div id="flip-counter" class="flip-counter"></div>
      </div>
      <button class="btn" onclick="newGame()">New game</button>
    </div>
  </div>
  </div>


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
</body>



</html>