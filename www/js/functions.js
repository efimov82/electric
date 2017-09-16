$(function(){
  window.gameCounter = new flipCounter('flip-counter', {value:0000, inc:1, auto:false});
  doRequest('state');
  
});

var audio = new Audio('/sounds/click.wav');

function newGame() {
  doRequest('start');
}

function doMove(gameCounter, number) {
  doRequest('move', number);
}
   
function doRequest(action, value='') {
  $.ajax({
    url: '/game.php?action='+action+'&value='+value,
  }).done(( responce ) => {
    var data = JSON.parse(responce);
    
    renderGame(data.matrix);
    
    if (window.gameCounter.getValue() !== data.count_moves) {
      gameCounter.add(1);
      audio.play();
    }
    window.gameCounter.setValue(data.count_moves);
    
    if (data.status == 'finished') {
      $('#modalSave').modal('show');
    }
    
  });
}
   
function renderGame(data) {
  var res = Object.keys(data).map((val) => {
    if (data[val]) {
      $("#cell-"+val).addClass('lightOn');
    } else {
      $("#cell-"+val).removeClass('lightOn');
    }
  });
}

function saveWinner() {
  var name = $('#player_name').val();
  doRequest('save', name);
  document.location = '/top.php';
}