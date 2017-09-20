$(function(){
  window.gameCounter = new flipCounter('flip-counter', {value:0000, auto:false});
  var data = doRequest('state');
  
  
  setInterval(function () {
    
    time = parseInt($('#timePlay').text()) + 1;
    $('#timePlay').text(time);
    $('#timePlaySpan').text(secondsToHms(time));
  }, 1000);
  
  setMode(currentMode);
  
  $('[data-toggle="tooltip"]').tooltip();
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
  
  var difficulty = $('#game-difficulty').val();
  difficulty += '&game_size=' + $('#game-size').val();
  //doRequest('start', difficulty);
  
  $.ajax({
    url: '/game.php?action=start&value='+difficulty
  }).done(( responce ) => {
    window.location.reload(true);
  }
  );
  
  //window.window.location = '';
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
  
  var ids = ['btnModeNormal', 'btnModeFreeze', 'btnModeVline', 'btnModeGline', 'btnModeCross'];
  ids.map( value => {
    $("#"+value).prop('disabled', false);
    $("#"+value).removeClass('btn-warning');
  });
  
  if (mode == 'move') {
    $("#btnModeNormal").addClass('btn-warning');
  }
  
  if (mode == 'freeze') {
    //$("#btnModeFreeze").prop('disabled', true);
    $("#btnModeFreeze").addClass('btn-warning');
  }
  
  if (mode == 'vline') {
    $("#btnModeVline").addClass('btn-warning');
  }
  
  if (mode == 'gline') {
    $("#btnModeGline").addClass('btn-warning');
  }
  
  if (mode == 'cross') {
    $("#btnModeCross").addClass('btn-warning');
  }
}   
   
function doRequest(action, value='', reload=false) {
  
  $.ajax({
    url: '/game.php?action='+action+'&value='+value,
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
    
    /*if (reload) {
      location.reload(true);
    }*/
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


function secondsToHms(d) {
    d = Number(d);

    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    return ('0' + h).slice(-2) + ":" + ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
}