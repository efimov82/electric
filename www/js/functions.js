$(function(){
  window.gameCounter = new flipCounter('flip-counter', {value:0000, auto:false});
  var data = doRequest('state');
  
  
  setInterval(function () {
    time = parseInt($('#timePlay').text()) + 1;
    $('#timePlay').text(time);
  }, 1000);
  
});

var audio = new Audio('/sounds/click.wav');
var currentMode = 'move';
// const
var LS_OFF = 1;
var LS_ON = 2;
var LS_OFF_FREEZED = 5;
var LS_ON_FREEZED = 6;
// dificults
var DIFFICULTYS = {1:'EASY', 2:'NORMAL', 3:'HARD'};

function newGame() {
  
  var diff = $('#game-difficulty').val();
  doRequest('start', diff);
  $('#modalNew').modal('hide');
}

function doMove(gameCounter, number) {
  doRequest(currentMode, number);
  /*if (currentMode == 'freeze')
    doRequest('freeze', number);
  else
    doRequest('move', number);
  */
}
   
function setMode(mode) {
  currentMode = mode;
  //button.disable = true;
}   
   
function doRequest(action, value='') {
  
  $.ajax({
    url: '/game.php?v=2&action='+action+'&value='+value,
  }).done(( responce ) => {
    var data = JSON.parse(responce);
    
    renderGameField(data.matrix);
    renderGameInfo(data);
    console.log('value='+value);
    
    if (window.gameCounter.getValue() !== data.countMoves) {
      gameCounter.add(1);
      audio.play();
    }
    window.gameCounter.setValue(data.countMoves);
    
    if (data.status == 'finished') {
      $('#player_name').val(data.player_name);
      $('#modalSave').modal('show');
    }
    
  });
}
   
function renderGameField(data) {
  
  var res = Object.keys(data).map((val) => {
    // clear cell
    var cellId = "#cell-"+val;
    $(cellId).removeClass('lightOn');
    $(cellId).removeClass('lightOnFreezed');
    $(cellId).removeClass('lightOffFreezed');
    
    
    if (data[val] == LS_ON) {
      $(cellId).addClass('lightOn');
    } else if (data[val] == LS_ON_FREEZED) {
      $("#cell-"+val).addClass('lightOnFreezed');
    } else if (data[val] == LS_OFF_FREEZED) {
      $("#cell-"+val).addClass('lightOffFreezed');
    }
  });
}

/**
 * 
 * @param {array} data [difficulty, status, timeStart, countFreezes]
 * @returns {void}
 */
function renderGameInfo(data) {
  
  $('#difficultyLevel').text(DIFFICULTYS[data.difficulty]);
  $('#countFreeze').text(data.countFreezes);
  $('#timePlay').text(data.timePlay);
}

function saveWinner() {
  var name = $('#player_name').val();
  doRequest('save', name);
  document.location = '/top.php';
}
